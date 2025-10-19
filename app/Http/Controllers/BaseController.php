<?php

namespace App\Http\Controllers;

use App\Services\File\FileUploadService;
use App\Traits\HasDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BaseController extends Controller
{
    use HasDataTable;

    public function __construct(
        protected readonly FileUploadService $fileUploadService
    ) {}

    public function successResponse(string $message, string $title = 'Success', $data = null, array $additionalData = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        // Only add title if it's different from default or explicitly provided
        if ($title !== 'Success') {
            $response['title'] = $title;
        }

        // Add data field if provided
        if ($data !== null) {
            $response['data'] = $data;
        }

        // Merge any additional fields (like 'files', 'errors', etc.)
        if (! empty($additionalData)) {
            $response = array_merge($response, $additionalData);
        }

        return response()->json($response);
    }

    public function errorResponse(string $message, string $title = 'Error', $data = null, int $statusCode = 400, array $additionalData = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        // Only add title if it's different from default or explicitly provided
        if ($title !== 'Error') {
            $response['title'] = $title;
        }

        // Add data field if provided
        if ($data !== null) {
            $response['data'] = $data;
        }

        // Merge any additional fields (like 'errors', etc.)
        if (! empty($additionalData)) {
            $response = array_merge($response, $additionalData);
        }

        return response()->json($response, $statusCode);
    }

    public function successWithToast(string $message, string $title = 'Success', ?string $route = null)
    {
        $redirect = $route ? redirect()->route($route) : redirect()->back();

        return $redirect->with([
            'success' => true,
            'toast' => [
                'type' => 'success',
                'title' => $title,
                'message' => $message,
            ],
        ]);
    }

    public function errorWithToast(string $message, string $title = 'Error', ?string $route = null)
    {
        $redirect = $route ? redirect()->route($route) : redirect()->back();

        return $redirect->with([
            'success' => false,
            'toast' => [
                'type' => 'error',
                'title' => $title,
                'message' => $message,
            ],
        ]);
    }

    // ========================================================
    // Start File Upload
    // ========================================================

    /**
     * Upload files temporarily to storage/temp
     *
     * Handles temporary file uploads.
     *
     * This method is integrated with the dashboard and
     * is utilized by the dashboard file upload component.
     */
    public function uploadTemp(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'files' => 'required|array',
                'files.*' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240', // 10MB max
                'context' => 'sometimes|string|max:50|regex:/^[a-zA-Z0-9_-]+$/',
            ], [
                'files.*.max' => 'The file ":attribute" is too large. Maximum size allowed is 10MB.',
                'files.*.mimes' => 'The file ":attribute" must be an image of type: jpeg, png, jpg, gif, svg, or webp.',
                'files.*.file' => 'The uploaded file ":attribute" is not valid.',
            ]);

            $context = $request->input('context', 'general');
            $uploadedFiles = $this->fileUploadService->uploadTemp(
                $request->file('files'),
                $context
            );

            return $this->successResponse(
                'Files uploaded successfully',
                'Success',
                null,
                ['files' => $uploadedFiles]
            );
        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                'Error',
                null,
                422,
                ['errors' => $e->errors()]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Upload failed: ' . $e->getMessage(),
                'Error',
                null,
                500
            );
        }
    }

    /**
     * Delete a temporary file from storage/temp.
     *
     * This endpoint is called by dashboard file upload components to delete specific
     * temporary files before finalizing a model (e.g., when removing images on the edit/create UI).
     *
     * Expects a "temp_path" string in the request payload.
     */
    public function deleteTemp(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'temp_path' => 'required|string',
            ]);

            $tempPath = $request->input('temp_path');
            $deleted = $this->fileUploadService->deleteTemp($tempPath);

            if (! $deleted) {
                return $this->errorResponse('File not found', 'Error', null, 404);
            }

            return $this->successResponse('File deleted successfully');
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse($e->getMessage(), 'Error', null, 400);
        } catch (\Exception $e) {
            return $this->errorResponse('Delete failed: ' . $e->getMessage(), 'Error', null, 500);
        }
    }

    /**
     * Clean up old temporary files (can be called via scheduled command)
     *
     * This endpoint is called by the CleanupTempFiles command to delete
     * old temporary files from storage/temp.
     *
     * Expects an optional "hours" parameter to specify how old the files should be.
     */
    public function cleanupTemp(): JsonResponse
    {
        try {
            $deletedCount = $this->fileUploadService->cleanupOldFiles(24);

            return $this->successResponse(
                "Cleaned up {$deletedCount} temporary files",
                'Success',
                ['count' => $deletedCount]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Cleanup failed: ' . $e->getMessage(),
                'Error',
                null,
                500
            );
        }
    }

    /**
     * Convert existing media to file upload component format
     *
     * This method transforms media library items into the format expected by
     * the dashboard file upload component for editing purposes.
     *
     * @param  mixed  $model  The model with media
     * @param  string  $collection  The media collection name
     * @return array Array of files in temp file format
     */
    public function getExistingFilesForEdit($model, string $collection): array
    {
        return $model->getMedia($collection)->map(function ($media) {
            return [
                'temp_path' => null, // Not a temp file
                'original_name' => $media->file_name,
                'size' => $media->size,
                'mime_type' => $media->mime_type,
                'url' => $media->getUrl(),
                'media_id' => $media->id, // Keep track of existing media
                'is_existing' => true, // Flag to identify existing files
            ];
        })->toArray();
    }

    /**
     * Update media files for a model
     * Handles both existing files (to keep) and new temporary files (to add)
     *
     *
     * @param  mixed  $model  The model to update media for
     * @param  array  $tempFiles  Array of files (existing and new)
     * @param  string  $collection  The media collection name
     * @return int Number of new files added
     */
    public function updateMediaFiles($model, array $tempFiles, string $collection): int
    {
        // Get IDs of existing media to keep
        $existingMediaIds = collect($tempFiles)
            ->where('is_existing', true)
            ->pluck('media_id')
            ->filter()
            ->toArray();

        // Delete media that are not in the list
        $model->getMedia($collection)
            ->whereNotIn('id', $existingMediaIds)
            ->each(fn($media) => $media->delete());

        // Add new temporary files
        $newFiles = collect($tempFiles)
            ->where('is_existing', false)
            ->whereNotNull('temp_path')
            ->toArray();

        $filesAdded = 0;
        if (! empty($newFiles)) {
            $filesAdded = $this->fileUploadService->moveToMediaLibrary(
                $model,
                $newFiles,
                $collection
            );
        }

        return $filesAdded;
    }

    /**
     * Get new temporary files from temp_files array (excludes existing files)
     *
     * @param  array  $tempFiles  Array of files (existing and new)
     * @return array Array of only new temporary files
     */
    public function getNewTempFiles(array $tempFiles): array
    {
        return collect($tempFiles)
            ->where('is_existing', false)
            ->whereNotNull('temp_path')
            ->toArray();
    }

    // ========================================================
    // End File Upload
    // ========================================================
}
