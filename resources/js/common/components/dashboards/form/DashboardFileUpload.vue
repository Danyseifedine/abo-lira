<script setup lang="ts">
import { __ } from '@/core/utils/translations';
import { usePage } from '@inertiajs/vue3';
import { CheckCircle2, FileIcon, FileText, ImageIcon, Upload, X } from 'lucide-vue-next';
import FileUpload, { type FileUploadSelectEvent, type FileUploadUploaderEvent } from 'primevue/fileupload';
import { computed, nextTick, ref } from 'vue';

export interface TemporaryFile {
    id?: number; // Media ID for existing files
    temp_path?: string; // Temp path for new uploads
    original_name: string;
    size: number;
    mime_type: string;
    url: string;
    original_url?: string; // Original URL for existing media
}

export interface DashboardFileUploadProps {
    modelValue?: TemporaryFile[] | null;
    deletedMediaIds?: number[]; // Track deleted existing media IDs
    name?: string;
    url?: string;
    accept?: string;
    maxFileSize?: number; // in bytes
    maxFiles?: number;
    multiple?: boolean;
    auto?: boolean;
    disabled?: boolean;
    error?: string | null;
    showUploadButton?: boolean;
    showCancelButton?: boolean;
    customUpload?: boolean;
    fileLimit?: number;
    chooseLabel?: string;
    uploadLabel?: string;
    cancelLabel?: string;
    invalidFileSizeMessage?: string;
    invalidFileTypeMessage?: string;
    previewWidth?: number;
    id?: string;
    class?: string;
    context?: string; // NEW: Context for organizing files (e.g., 'products', 'blogs', 'galleries')
}

const props = withDefaults(defineProps<DashboardFileUploadProps>(), {
    name: 'files[]',
    accept: '*',
    maxFileSize: 5000000, // 5MB default
    maxFiles: 10,
    multiple: true,
    auto: true, // Changed default to true for automatic upload
    disabled: false,
    error: null,
    showUploadButton: true,
    showCancelButton: true,
    customUpload: true, // Always use custom upload for temp files
    fileLimit: undefined,
    chooseLabel: 'Choose Files',
    uploadLabel: 'Upload',
    cancelLabel: 'Cancel',
    invalidFileSizeMessage: '{0}: Invalid file size, file size should be smaller than {1}.',
    invalidFileTypeMessage: '{0}: Invalid file type, allowed file types: {1}.',
    previewWidth: 100,
    context: 'general', // Default context
});

const emit = defineEmits<{
    'update:modelValue': [files: TemporaryFile[]];
    'update:deletedMediaIds': [ids: number[]];
    upload: [event: FileUploadUploaderEvent];
    select: [event: FileUploadSelectEvent];
    remove: [event: { file: File; files: File[] }];
    clear: [];
    error: [event: any];
    'before-upload': [event: any];
    progress: [event: any];
    'before-send': [event: any];
    'temp-uploaded': [files: TemporaryFile[]];
    'temp-deleted': [tempPath: string];
}>();

const fileUploadRef = ref<any>(null);
const selectedFiles = ref<File[]>([]);
const tempFiles = ref<TemporaryFile[]>(props.modelValue || []);
const deletedIds = ref<number[]>(props.deletedMediaIds || []);
const isUploading = ref(false);
const isDeleting = ref(false);
const uploadProgress = ref(0);
const currentError = ref<string | null>(null);
const page = usePage();

// Check if file limit is reached
const isFileLimitReached = computed(() => {
    if (!props.fileLimit) return false;
    const currentLength = tempFiles.value.length;
    const limitReached = currentLength >= props.fileLimit;

    // Debug log to track state changes
    console.log('File limit check:', {
        fileLimit: props.fileLimit,
        currentLength,
        limitReached,
        tempFiles: tempFiles.value,
    });

    return limitReached;
});

// Get CSRF token from multiple sources
const getCsrfToken = (): string => {
    // Try to get from Inertia page props first
    if (page.props._token) {
        return page.props._token as string;
    }

    // Fallback to meta tag
    const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (metaToken) {
        return metaToken;
    }

    // Last resort - try to get from cookie
    const cookies = document.cookie.split(';');
    for (const cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'XSRF-TOKEN') {
            return decodeURIComponent(value);
        }
    }

    return '';
};

// Format file size for display
const formatSize = (bytes: number) => {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

// Show error with auto-dismiss
const showError = (message: string, duration: number = 5000) => {
    currentError.value = message;
    setTimeout(() => {
        currentError.value = null;
    }, duration);
};

// Get user-friendly error message
const getErrorMessage = (error: any, file?: File): string => {
    if (typeof error === 'string') return error;

    if (error.message) {
        // Handle validation errors
        if (error.message.includes('413') || error.message.includes('file size') || error.message.includes('too large')) {
            const fileName = file?.name || 'File';
            const fileSize = file ? formatSize(file.size) : '';
            const maxSize = formatSize(props.maxFileSize);
            return `${fileName} is too large (${fileSize}). Maximum size allowed is ${maxSize}.`;
        }

        if (error.message.includes('type') || error.message.includes('format') || error.message.includes('mimes')) {
            const fileName = file?.name || 'File';
            return `${fileName} has an invalid format. Allowed formats: ${props.accept}`;
        }

        if (error.message.includes('network') || error.message.includes('fetch')) {
            return 'Network error. Please check your connection and try again.';
        }

        if (error.message.includes('422') || error.message.includes('Validation failed')) {
            return 'File validation failed. Please check file size and format.';
        }

        return error.message;
    }

    // Handle Laravel validation response format
    if (error.errors) {
        const firstError = Object.values(error.errors)[0];
        if (Array.isArray(firstError) && firstError.length > 0) {
            return firstError[0] as string;
        }
    }

    return 'An unexpected error occurred. Please try again.';
};

// Handle file selection - automatically upload to temp only if auto=true
const onSelect = async (event: FileUploadSelectEvent) => {
    // Check file limit before processing
    if (props.fileLimit && tempFiles.value.length >= props.fileLimit) {
        const unit = props.fileLimit === 1 ? __('datatable.file_upload.file') : __('datatable.file_upload.files');
        const message = __('datatable.file_upload.maximum_files_allowed').replace(':count', props.fileLimit.toString()).replace(':unit', unit);
        showError(message);
        return;
    }

    selectedFiles.value = event.files;
    emit('select', event);

    // Only auto-upload if auto=true
    if (props.auto) {
        await uploadToTemp(event.files);
    }
};

// Upload files to temporary storage
const uploadToTemp = async (files: File[]) => {
    if (files.length === 0) return;

    // Check file limit before uploading
    if (props.fileLimit && tempFiles.value.length >= props.fileLimit) {
        const unit = props.fileLimit === 1 ? __('datatable.file_upload.file') : __('datatable.file_upload.files');
        const message = __('datatable.file_upload.maximum_files_allowed').replace(':count', props.fileLimit.toString()).replace(':unit', unit);
        showError(message);
        return;
    }

    // Clear any previous errors
    currentError.value = null;
    isUploading.value = true;
    uploadProgress.value = 0;

    try {
        // Validate files before upload
        for (const file of files) {
            if (file.size > props.maxFileSize) {
                throw new Error(`File size validation failed for ${file.name}`);
            }

            if (props.accept !== '*' && !file.type.match(new RegExp(props.accept.replace('*', '.*')))) {
                throw new Error(`File type validation failed for ${file.name}`);
            }
        }

        const formData = new FormData();
        files.forEach((file) => {
            formData.append('files[]', file);
        });
        // Add context for organizing files
        formData.append('context', props.context || 'general');

        // Simulate progress for better UX
        const progressInterval = setInterval(() => {
            if (uploadProgress.value < 90) {
                uploadProgress.value += Math.random() * 20;
            }
        }, 200);

        // Use fetch but with proper CSRF token handling
        const response = await fetch(route('uploads.temp.store'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                Accept: 'application/json',
            },
        });

        clearInterval(progressInterval);
        uploadProgress.value = 100;

        if (!response.ok) {
            let errorMessage = `HTTP ${response.status}: ${response.statusText}`;

            try {
                const errorResult = await response.json();
                if (errorResult.errors) {
                    // Handle Laravel validation errors
                    const firstError = Object.values(errorResult.errors)[0];
                    if (Array.isArray(firstError) && firstError.length > 0) {
                        errorMessage = firstError[0] as string;
                    }
                } else if (errorResult.message) {
                    errorMessage = errorResult.message;
                }
            } catch {
                // If we can't parse JSON, use status-based messages
                if (response.status === 413) {
                    errorMessage = 'File size too large';
                } else if (response.status === 422) {
                    errorMessage = 'File validation failed';
                }
            }

            throw new Error(errorMessage);
        }

        const result = await response.json();

        if (result.success) {
            // If multiple=false, replace existing temp files with new one
            if (props.multiple === false) {
                // Clear existing temp files first
                const filesToDelete = [...tempFiles.value];
                for (const tempFile of filesToDelete) {
                    // Delete from server but don't wait for response
                    removeTempFile(tempFile);
                }
                tempFiles.value = result.files;
            } else {
                // If multiple=true, add to existing temp files
                const newTempFiles = [...tempFiles.value, ...result.files];
                tempFiles.value = newTempFiles;
            }

            emit('update:modelValue', tempFiles.value);
            emit('temp-uploaded', result.files);

            // Clear the file input
            clearFileInput();
        } else {
            throw new Error(result.message || 'Upload failed');
        }
    } catch (error) {
        const errorMessage = getErrorMessage(error, files[0]);
        showError(errorMessage);
        emit('error', { message: errorMessage });
    } finally {
        isUploading.value = false;
        uploadProgress.value = 0;
    }
};

// Handle file upload (custom uploader)
const customUploader = async (event: FileUploadUploaderEvent) => {
    const files = Array.isArray(event.files) ? event.files : [event.files];
    await uploadToTemp(files);
};

// Handle file removal from temp storage
const removeTempFile = async (tempFile: TemporaryFile) => {
    isDeleting.value = true;

    try {
        // If it's an existing file (not a temp file), just remove from UI
        // The backend will handle deletion during update
        if ((tempFile as any).is_existing || tempFile.id) {
            // Track the deleted media ID
            const mediaId = tempFile.id || (tempFile as any).media_id;
            if (mediaId && !deletedIds.value.includes(mediaId)) {
                deletedIds.value.push(mediaId);
                emit('update:deletedMediaIds', deletedIds.value);
            }

            const updatedFiles = tempFiles.value.filter((f) => {
                // For existing files, compare by id or media_id or url
                if (f.id && mediaId) {
                    return f.id !== mediaId;
                }
                if ((f as any).is_existing && (tempFile as any).media_id) {
                    return (f as any).media_id !== (tempFile as any).media_id;
                }
                return f.url !== tempFile.url;
            });
            tempFiles.value = updatedFiles;
            emit('update:modelValue', updatedFiles);
            emit('temp-deleted', tempFile.temp_path || tempFile.url);

            // Force DOM update
            await nextTick();
            isDeleting.value = false;
            return;
        }

        // For temp files, delete from server
        const response = await fetch(route('uploads.temp.destroy'), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                Accept: 'application/json',
            },
            body: JSON.stringify({ temp_path: tempFile.temp_path }),
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const result = await response.json();

        if (result.success) {
            const updatedFiles = tempFiles.value.filter((f) => f.temp_path !== tempFile.temp_path);
            tempFiles.value = updatedFiles;
            emit('update:modelValue', updatedFiles);
            emit('temp-deleted', tempFile.temp_path);

            // Force DOM update
            await nextTick();
        } else {
            throw new Error(result.message || 'Delete failed');
        }
    } catch (error) {
        const errorMessage = getErrorMessage(error);
        showError(errorMessage);
        emit('error', { message: errorMessage });
    } finally {
        isDeleting.value = false;
    }
};

// Handle file removal (for selected files before upload)
const onRemove = (event: any) => {
    const remainingFiles = selectedFiles.value.filter((f) => f !== event.file);
    selectedFiles.value = remainingFiles;
    emit('remove', { file: event.file, files: remainingFiles });
};

// Handle clear all (only when user explicitly clears)
const onClear = async () => {
    isDeleting.value = true;

    try {
        // Clear selected files
        selectedFiles.value = [];

        // Separate temp files from existing files (existing files don't need server deletion)
        const tempFilesToDelete = tempFiles.value.filter((f) => !(f as any).is_existing && f.temp_path);

        // Delete only temp files from server
        if (tempFilesToDelete.length > 0) {
            const deletePromises = tempFilesToDelete.map((tempFile) =>
                fetch(route('uploads.temp.destroy'), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({ temp_path: tempFile.temp_path }),
                }).catch((error) => {
                    console.error('Failed to delete temp file:', tempFile.temp_path, error);
                }),
            );
            await Promise.allSettled(deletePromises);
        }

        // Clear all files from UI
        tempFiles.value = [];
        emit('update:modelValue', []);
        emit('clear');
    } catch (error) {
        const errorMessage = getErrorMessage(error);
        showError(errorMessage);
    } finally {
        isDeleting.value = false;
    }
};

// Clear just the file input without deleting temp files
const clearFileInput = () => {
    selectedFiles.value = [];
    if (fileUploadRef.value) {
        fileUploadRef.value.files = [];
    }
};

// Handle errors
const onError = (event: any) => {
    emit('error', event);
};

// Get file icon based on file type
const getFileIcon = (file: File | TemporaryFile) => {
    const type = 'type' in file ? file.type : file.mime_type;
    if (type.startsWith('image/')) return ImageIcon;
    if (type === 'application/pdf') return FileText;
    return FileIcon;
};

// Check if file is image
const isImage = (file: File | TemporaryFile) => {
    const type = 'type' in file ? file.type : file.mime_type;
    return type.startsWith('image/');
};

// Get object URL for preview
const getObjectURL = (file: File) => {
    return URL.createObjectURL(file);
};

// Get preview URL for temp file
const getPreviewURL = (tempFile: TemporaryFile) => {
    return tempFile.url;
};

// Expose methods for parent component
defineExpose({
    clear: onClear,
    getTempFiles: () => tempFiles.value,
});
</script>

<template>
    <div class="dashboard-file-upload" :class="props.class">
        <FileUpload
            :key="`fileupload-${tempFiles.length}-${isFileLimitReached}`"
            ref="fileUploadRef"
            :name="name"
            :url="url"
            :accept="accept"
            :maxFileSize="maxFileSize"
            :multiple="multiple"
            :auto="auto"
            :disabled="disabled || isFileLimitReached"
            :customUpload="customUpload"
            :fileLimit="fileLimit"
            :chooseLabel="chooseLabel"
            :uploadLabel="uploadLabel"
            :cancelLabel="cancelLabel"
            :invalidFileSizeMessage="invalidFileSizeMessage"
            :invalidFileTypeMessage="invalidFileTypeMessage"
            :showUploadButton="showUploadButton"
            :showCancelButton="showCancelButton"
            @select="onSelect"
            @upload="customUpload ? customUploader : onUpload"
            @remove="onRemove"
            @clear="onClear"
            @error="onError"
            @before-upload="emit('before-upload', $event)"
            @progress="emit('progress', $event)"
            @before-send="emit('before-send', $event)"
        >
            <!-- Custom header template -->
            <template #header="{ chooseCallback, clearCallback, files }">
                <!-- Clickable Upload Area -->
                <div
                    :key="`upload-area-${tempFiles.length}-${isFileLimitReached}`"
                    @click="!disabled && !isUploading && !isDeleting && !isFileLimitReached ? chooseCallback() : null"
                    class="w-full cursor-pointer border-b p-8 transition-colors hover:bg-muted/30"
                    :class="{
                        'cursor-not-allowed opacity-50': disabled || isUploading || isDeleting || isFileLimitReached,
                        'hover:bg-muted/30': !disabled && !isUploading && !isDeleting && !isFileLimitReached,
                    }"
                >
                    <div class="mx-auto flex w-full max-w-md flex-col items-center justify-center gap-4 text-center">
                        <div class="rounded-full bg-primary/10 p-4">
                            <Upload class="h-8 w-8 text-primary" />
                        </div>

                        <div class="w-full space-y-2">
                            <h3 class="text-lg font-semibold text-foreground">
                                <span v-if="isFileLimitReached">{{ __('datatable.file_upload.file_limit_reached') }}</span>
                                <span v-else-if="tempFiles.length === 0">{{ __('datatable.file_upload.click_to_upload') }}</span>
                                <span v-else>{{ __('datatable.file_upload.click_to_add_more') }}</span>
                            </h3>
                            <p class="text-sm text-muted-foreground">
                                <span v-if="isFileLimitReached">
                                    {{
                                        __('datatable.file_upload.maximum_files_allowed')
                                            .replace(':count', props.fileLimit?.toString() || '')
                                            .replace(
                                                ':unit',
                                                props.fileLimit === 1 ? __('datatable.file_upload.file') : __('datatable.file_upload.files'),
                                            )
                                    }}
                                </span>
                                <span v-else>
                                    {{
                                        tempFiles.length > 0
                                            ? __('datatable.file_upload.drag_and_drop_additional')
                                            : __('datatable.file_upload.drag_and_drop')
                                    }}
                                </span>
                            </p>
                        </div>

                        <!-- Upload Progress Indicator -->
                        <div v-if="isUploading" class="flex w-full max-w-xs flex-col items-center gap-2">
                            <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                                <div
                                    class="h-full bg-gradient-to-r from-blue-500 to-green-500 transition-all duration-300 ease-out"
                                    :style="{ width: uploadProgress + '%' }"
                                ></div>
                            </div>
                            <span class="text-sm font-medium text-blue-600">{{ Math.round(uploadProgress) }}%</span>
                        </div>

                        <!-- File Count Info -->
                        <div v-if="tempFiles.length > 0 || files.length > 0" class="flex items-center gap-4 text-xs text-muted-foreground">
                            <span v-if="files.length > 0">{{ files.length }} {{ __('datatable.file_upload.selected') }}</span>
                            <span v-if="tempFiles.length > 0">{{ tempFiles.length }} {{ __('datatable.file_upload.uploaded') }}</span>
                            <span v-if="props.fileLimit">{{ tempFiles.length }}/{{ props.fileLimit }} {{ __('datatable.file_upload.files') }}</span>
                        </div>

                        <!-- Clear All Button (only show when we have files) -->
                        <div v-if="tempFiles.length > 0 || files.length > 0" class="pt-2">
                            <button
                                type="button"
                                @click.stop="clearCallback()"
                                :disabled="disabled || isUploading"
                                class="inline-flex items-center gap-2 rounded-md bg-destructive px-4 py-2 text-sm font-medium text-destructive-foreground transition-colors hover:bg-destructive/90 disabled:pointer-events-none disabled:opacity-50"
                            >
                                <span v-if="!isDeleting" class="flex items-center gap-2">
                                    <X class="h-4 w-4" />
                                    {{ __('datatable.file_upload.clear_all') }}
                                </span>
                                <span v-else class="flex items-center gap-2">
                                    <div class="h-4 w-4 animate-spin rounded-full border-2 border-red-400 border-t-transparent"></div>
                                    {{ __('datatable.file_upload.clearing') }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Error Display -->
                <div v-if="currentError" class="border-b bg-red-50 p-4 duration-300 animate-in slide-in-from-top-2 dark:bg-red-950/20">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50">
                                <X class="h-4 w-4 text-red-600 dark:text-red-400" />
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('datatable.file_upload.upload_error') }}</p>
                            <p class="mt-1 text-sm text-red-700 dark:text-red-300">{{ currentError }}</p>
                        </div>
                        <button
                            @click="currentError = null"
                            class="flex-shrink-0 rounded-md p-1 transition-colors hover:bg-red-100 dark:hover:bg-red-900/50"
                        >
                            <X class="h-4 w-4 text-red-600 dark:text-red-400" />
                        </button>
                    </div>
                </div>
            </template>

            <!-- Custom content template for selected files -->
            <template #content="{ files, removeFileCallback }">
                <div v-if="files.length > 0 || tempFiles.length > 0" class="p-4">
                    <!-- Selected Files (being uploaded) -->
                    <div v-if="files.length > 0" class="mb-6">
                        <h4 class="mb-3 flex items-center gap-2 text-sm font-semibold">
                            <Upload class="h-4 w-4 text-blue-600" />
                            <span v-if="!isUploading">{{ __('datatable.file_upload.selected_files') }}</span>
                            <span v-else>{{ __('datatable.file_upload.uploading_files') }}</span>
                            <div v-if="isUploading" class="ml-2">
                                <div class="h-4 w-4 animate-spin rounded-full border-2 border-blue-600 border-t-transparent"></div>
                            </div>
                        </h4>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div
                                v-for="(file, index) in files"
                                :key="file.name + index"
                                class="group relative overflow-hidden rounded-lg border transition-all duration-200"
                                :class="{
                                    'opacity-75': isUploading,
                                    'hover:border-primary': !isUploading,
                                }"
                            >
                                <!-- Image Preview -->
                                <div v-if="isImage(file)" class="relative flex aspect-video items-center justify-center bg-muted">
                                    <img
                                        :src="getObjectURL(file)"
                                        :alt="file.name"
                                        class="h-full w-full object-cover transition-all duration-300"
                                        :class="{ 'opacity-90': isUploading }"
                                    />

                                    <!-- Upload Progress Overlay -->
                                    <div v-if="isUploading" class="absolute inset-0 flex flex-col items-center justify-center bg-black/30">
                                        <div class="border-3 mb-2 h-8 w-8 animate-spin rounded-full border-white border-t-transparent"></div>
                                        <div class="h-1.5 w-20 overflow-hidden rounded-full bg-white/40">
                                            <div
                                                class="h-full bg-white transition-all duration-300 ease-out"
                                                :style="{ width: uploadProgress + '%' }"
                                            ></div>
                                        </div>
                                        <span class="mt-1 text-xs font-medium text-white">{{ Math.round(uploadProgress) }}%</span>
                                    </div>

                                    <button
                                        v-if="!isUploading"
                                        type="button"
                                        @click="removeFileCallback(index)"
                                        class="absolute right-2 top-2 rounded-full bg-destructive p-1.5 text-destructive-foreground opacity-0 transition-opacity hover:bg-destructive/90 group-hover:opacity-100"
                                    >
                                        <X class="h-4 w-4" />
                                    </button>
                                </div>

                                <!-- Non-Image Preview -->
                                <div v-else class="relative flex aspect-video items-center justify-center bg-muted">
                                    <component
                                        :is="getFileIcon(file)"
                                        class="h-16 w-16 text-muted-foreground transition-all duration-300"
                                        :class="{ 'opacity-90': isUploading }"
                                    />

                                    <!-- Upload Progress Overlay -->
                                    <div v-if="isUploading" class="absolute inset-0 flex flex-col items-center justify-center bg-black/15">
                                        <div class="border-3 mb-2 h-8 w-8 animate-spin rounded-full border-blue-600 border-t-transparent"></div>
                                        <div class="h-1.5 w-20 overflow-hidden rounded-full bg-blue-100">
                                            <div
                                                class="h-full bg-blue-600 transition-all duration-300 ease-out"
                                                :style="{ width: uploadProgress + '%' }"
                                            ></div>
                                        </div>
                                        <span class="mt-1 text-xs font-medium text-blue-600">{{ Math.round(uploadProgress) }}%</span>
                                    </div>

                                    <button
                                        v-if="!isUploading"
                                        type="button"
                                        @click="removeFileCallback(index)"
                                        class="absolute right-2 top-2 rounded-full bg-destructive p-1.5 text-destructive-foreground opacity-0 transition-opacity hover:bg-destructive/90 group-hover:opacity-100"
                                    >
                                        <X class="h-4 w-4" />
                                    </button>
                                </div>

                                <!-- File Info -->
                                <div class="border-t bg-background p-3">
                                    <p class="truncate text-sm font-medium" :title="file.name" :class="{ 'text-muted-foreground/70': isUploading }">
                                        {{ file.name }}
                                    </p>
                                    <p class="mt-1 text-xs text-muted-foreground">
                                        {{ formatSize(file.size) }}
                                    </p>
                                    <div v-if="isUploading" class="mt-2 flex items-center gap-2 text-xs text-blue-600">
                                        <div class="h-2 w-2 animate-pulse rounded-full bg-blue-600"></div>
                                        {{ __('datatable.file_upload.uploading') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Temporary Files (uploaded successfully) -->
                    <div v-if="tempFiles.length > 0">
                        <h4 class="mb-3 flex items-center gap-2 text-sm font-semibold">
                            <CheckCircle2 class="h-4 w-4 text-green-600" />
                            {{ __('datatable.file_upload.uploaded_files') }}
                        </h4>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div
                                v-for="tempFile in tempFiles"
                                :key="tempFile.temp_path"
                                class="group relative overflow-hidden rounded-lg border border-green-200 bg-green-50/50 transition-colors hover:border-green-300 dark:border-green-800 dark:bg-green-950/20"
                            >
                                <!-- Image Preview -->
                                <div v-if="isImage(tempFile)" class="relative flex aspect-video items-center justify-center bg-muted">
                                    <img :src="getPreviewURL(tempFile)" :alt="tempFile.original_name" class="h-full w-full object-cover" />
                                    <button
                                        type="button"
                                        @click="removeTempFile(tempFile)"
                                        :disabled="isDeleting"
                                        class="absolute right-2 top-2 rounded-full bg-destructive p-1.5 text-destructive-foreground opacity-0 transition-opacity hover:bg-destructive/90 disabled:opacity-50 group-hover:opacity-100"
                                    >
                                        <div
                                            v-if="isDeleting"
                                            class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"
                                        ></div>
                                        <X v-else class="h-4 w-4" />
                                    </button>
                                </div>

                                <!-- Non-Image Preview -->
                                <div v-else class="relative flex aspect-video items-center justify-center bg-muted">
                                    <component :is="getFileIcon(tempFile)" class="h-16 w-16 text-green-600" />
                                    <button
                                        type="button"
                                        @click="removeTempFile(tempFile)"
                                        :disabled="isDeleting"
                                        class="absolute right-2 top-2 rounded-full bg-destructive p-1.5 text-destructive-foreground opacity-0 transition-opacity hover:bg-destructive/90 disabled:opacity-50 group-hover:opacity-100"
                                    >
                                        <div
                                            v-if="isDeleting"
                                            class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"
                                        ></div>
                                        <X v-else class="h-4 w-4" />
                                    </button>
                                </div>

                                <!-- File Info -->
                                <div class="border-t bg-background p-3">
                                    <div class="flex items-center gap-2">
                                        <CheckCircle2 class="h-4 w-4 flex-shrink-0 text-green-600" />
                                        <p class="truncate text-sm font-medium text-green-800 dark:text-green-200" :title="tempFile.original_name">
                                            {{ tempFile.original_name }}
                                        </p>
                                    </div>
                                    <p class="mt-1 text-xs text-green-600/80">
                                        {{ formatSize(tempFile.size) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </FileUpload>

        <!-- Error message -->
        <p v-if="error" class="mt-2 text-xs text-destructive">
            {{ error }}
        </p>
    </div>
</template>

<style scoped>
.dashboard-file-upload :deep(.p-fileupload) {
    @apply rounded-lg border-2 border-dashed transition-colors;
}

.dashboard-file-upload :deep(.p-fileupload:hover) {
    border-color: #e4e4e4 !important;
}

.dark .dashboard-file-upload :deep(.p-fileupload:hover) {
    border-color: #262626 !important;
}

.dashboard-file-upload--error :deep(.p-fileupload) {
    @apply border-destructive;
}

.dashboard-file-upload--disabled :deep(.p-fileupload) {
    @apply cursor-not-allowed opacity-50;
}

.dashboard-file-upload :deep(.p-fileupload-content) {
    @apply border-0 p-0;
}

.dashboard-file-upload :deep(.p-fileupload-buttonbar) {
    @apply hidden;
}

.dashboard-file-upload :deep(.p-fileupload-header) {
    @apply border-0 p-0;
}

.dashboard-file-upload :deep(.p-fileupload-empty) {
    @apply hidden;
}
</style>
