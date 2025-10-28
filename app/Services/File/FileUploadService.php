<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload files temporarily to storage
     *
     * @param  array<UploadedFile>  $files
     */
    public function uploadTemp(array $files, string $context = 'general', int|string|null $userId = null): array
    {
        $userId = $userId ?? (Auth::check() ? Auth::id() : 'guest');
        $contextPath = "temp/{$context}/{$userId}";
        $uploadedFiles = [];

        foreach ($files as $file) {
            $uploadedFiles[] = $this->storeFile($file, $contextPath, $context);
        }

        return $uploadedFiles;
    }

    /**
     * Store a single file
     */
    private function storeFile(UploadedFile $file, string $path, string $context): array
    {
        // Generate unique filename with timestamp
        $timestamp = now()->timestamp;
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '-' . $timestamp . ($extension ? ".{$extension}" : '');

        // Store in context-specific directory within public disk
        $storedPath = $file->storeAs($path, $filename, 'public');

        return [
            'temp_path' => $storedPath,
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'url' => Storage::disk('public')->url($storedPath),
            'context' => $context,
            'uploaded_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Delete a temporary file
     *
     * @throws \InvalidArgumentException
     */
    public function deleteTemp(string $tempPath): bool
    {
        // Security check - ensure path is in temp directory and follows our structure
        if (! $this->isValidTempPath($tempPath)) {
            throw new \InvalidArgumentException('Invalid file path');
        }

        if (! Storage::disk('public')->exists($tempPath)) {
            return false;
        }

        return Storage::disk('public')->delete($tempPath);
    }

    /**
     * Check if a path is a valid temp path
     */
    private function isValidTempPath(string $path): bool
    {
        return str_starts_with($path, 'temp/') && ! str_contains($path, '..');
    }

    /**
     * Clean up old temporary files
     *
     * @return int Number of files deleted
     */
    public function cleanupOldFiles(int $hoursOld = 24): int
    {
        $tempFiles = Storage::disk('public')->allFiles('temp');
        $deletedCount = 0;
        $cutoffTime = now()->subHours($hoursOld);

        foreach ($tempFiles as $file) {
            // Skip .gitkeep files
            if (basename($file) === '.gitkeep') {
                continue;
            }

            $lastModified = Storage::disk('public')->lastModified($file);

            if ($lastModified < $cutoffTime->timestamp) {
                Storage::disk('public')->delete($file);
                $deletedCount++;
            }
        }

        // Clean up empty directories
        $this->cleanupEmptyDirectories('temp');

        return $deletedCount;
    }

    /**
     * Clean up empty directories recursively
     */
    private function cleanupEmptyDirectories(string $directory): void
    {
        $directories = Storage::disk('public')->directories($directory);

        foreach ($directories as $dir) {
            // Recursively clean subdirectories first
            $this->cleanupEmptyDirectories($dir);

            // Check if directory is empty (only contains .gitkeep or is completely empty)
            $files = Storage::disk('public')->files($dir);
            $subdirs = Storage::disk('public')->directories($dir);

            $isEmpty = empty($subdirs) && (
                empty($files) ||
                (count($files) === 1 && basename($files[0]) === '.gitkeep')
            );

            if ($isEmpty && $dir !== 'temp') { // Don't delete the main temp directory
                Storage::disk('public')->deleteDirectory($dir);
            }
        }
    }

    /**
     * Move temporary file to permanent storage
     *
     * @return string The new permanent path
     *
     * @throws \InvalidArgumentException
     */
    public function moveToPermanent(string $tempPath, string $destinationPath): string
    {
        if (! $this->isValidTempPath($tempPath)) {
            throw new \InvalidArgumentException('Invalid temp file path');
        }

        if (! Storage::disk('public')->exists($tempPath)) {
            throw new \InvalidArgumentException('Temp file does not exist');
        }

        // Move the file
        Storage::disk('public')->move($tempPath, $destinationPath);

        return $destinationPath;
    }

    /**
     * Get file info from temp path
     */
    public function getFileInfo(string $tempPath): ?array
    {
        if (! $this->isValidTempPath($tempPath) || ! Storage::disk('public')->exists($tempPath)) {
            return null;
        }

        return [
            'path' => $tempPath,
            'size' => Storage::disk('public')->size($tempPath),
            'mime_type' => Storage::disk('public')->mimeType($tempPath),
            'last_modified' => Storage::disk('public')->lastModified($tempPath),
            'url' => Storage::disk('public')->url($tempPath),
        ];
    }

    /**
     * Check if temp file exists
     */
    public function tempFileExists(string $tempPath): bool
    {
        return $this->isValidTempPath($tempPath) && Storage::disk('public')->exists($tempPath);
    }

    /**
     * Move temporary files to media library and clean up
     *
     * @param  \Spatie\MediaLibrary\HasMedia  $model
     * @return int Number of files added
     *
     * @throws \Exception
     */
    public function moveToMediaLibrary($model, array $tempFiles, string $collectionName = 'default'): int
    {
        $addedCount = 0;

        foreach ($tempFiles as $tempFileData) {
            $tempPath = $tempFileData['temp_path'];

            // Verify the temp file exists
            if (! $this->tempFileExists($tempPath)) {
                throw new \Exception("Invalid or missing temporary file: {$tempPath}");
            }

            // Add file to media library from temp storage
            $model->addMediaFromDisk($tempPath, 'public')
                ->usingName($tempFileData['original_name'])
                ->usingFileName($tempFileData['original_name'])
                ->toMediaCollection($collectionName);

            // Clean up temporary file
            $this->deleteTemp($tempPath);

            $addedCount++;
        }

        return $addedCount;
    }

    /**
     * Clean up temporary files (useful for error handling)
     *
     * @return array Array with 'deleted' and 'failed' counts
     */
    public function cleanupTempFiles(array $tempFiles): array
    {
        $deleted = 0;
        $failed = 0;

        foreach ($tempFiles as $tempFileData) {
            try {
                if ($this->deleteTemp($tempFileData['temp_path'])) {
                    $deleted++;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                logger()->warning('Failed to cleanup temp file', [
                    'path' => $tempFileData['temp_path'],
                    'error' => $e->getMessage(),
                ]);
                $failed++;
            }
        }

        return [
            'deleted' => $deleted,
            'failed' => $failed,
        ];
    }

    /**
     * Delete existing media files by their IDs from a model
     *
     * @param  \Spatie\MediaLibrary\HasMedia  $model
     * @return int Number of deleted media files
     */
    public function deleteExistingMedia($model, array $mediaIds, string $collectionName = 'default'): int
    {
        if (empty($mediaIds)) {
            return 0;
        }

        $deletedCount = 0;

        foreach ($mediaIds as $mediaId) {
            $media = $model->getMedia($collectionName)->where('id', $mediaId)->first();

            if ($media) {
                $media->delete();
                $deletedCount++;
            }
        }

        return $deletedCount;
    }

    /**
     * Handle media deletion from request data
     * Automatically extracts deleted_media_ids from data array
     *
     * @param  \Spatie\MediaLibrary\HasMedia  $model
     * @return int Number of deleted media files
     */
    public function handleMediaDeletion($model, array $data, string $collectionName = 'default'): int
    {
        $deletedMediaIds = $data['deleted_media_ids'] ?? [];

        $deletedCount = $this->deleteExistingMedia($model, $deletedMediaIds, $collectionName);

        return $deletedCount;
    }
}
