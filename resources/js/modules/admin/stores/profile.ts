import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import type { User, SharedData } from '@core/types';

export const useProfileStore = defineStore('profile', () => {
    // State
    const avatarInputRef = ref<HTMLInputElement | null>(null);
    const previewUrl = ref<string | null>(null);
    const isSubmitting = ref(false);

    // Get current user from Inertia shared props
    const page = usePage<SharedData>();
    const user = computed(() => page.props.auth.user as User);

    // Initialize form with current user data
    const form = useForm({
        name: user.value.name,
        email: user.value.email,
        avatar: null as File | string | null,
    });

    // Actions
    const initializeForm = () => {
        form.name = user.value.name;
        form.email = user.value.email;
        form.avatar = null;
        previewUrl.value = null;
        isSubmitting.value = false;
    };

    const handleAvatarChange = (event: Event) => {
        const target = event.target as HTMLInputElement;
        if (target.files && target.files[0]) {
            form.avatar = target.files[0];
            createPreview(target.files[0]);
        }
    };

    const createPreview = (file: File) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewUrl.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    };

    const selectImage = () => {
        avatarInputRef.value?.click();
    };

    const removeAvatar = () => {
        // Set form avatar to 'remove' to signal server to delete
        form.avatar = 'remove' as any;

        // Set preview to default image
        previewUrl.value = '/assets/images/default.jpg';
    };

    const submitProfile = () => {
        isSubmitting.value = true;

        form.post(route('super-admin.profile.update'), {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                // Clear preview URL and reset form avatar after successful save
                previewUrl.value = null;
                form.avatar = null;

                // Clear file input
                if (avatarInputRef.value) avatarInputRef.value.value = '';

                // Force reload of all shared data to update UI immediately
                router.reload();
            },
            onFinish: () => {
                isSubmitting.value = false;
            },
        });
    };

    const resetForm = () => {
        form.reset();
        previewUrl.value = null;
        isSubmitting.value = false;
        if (avatarInputRef.value) avatarInputRef.value.value = '';
    };

    const setAvatarInputRef = (element: HTMLInputElement | null) => {
        avatarInputRef.value = element;
    };

    // Getters
    const currentAvatarUrl = computed(() => {
        return previewUrl.value || user.value.avatar_url;
    });

    const hasAvatar = computed(() => {
        return !!(previewUrl.value || user.value.avatar_url);
    });

    return {
        // State
        user,
        form,
        previewUrl,
        isSubmitting,
        avatarInputRef,

        // Getters
        currentAvatarUrl,
        hasAvatar,

        // Actions
        initializeForm,
        handleAvatarChange,
        createPreview,
        selectImage,
        removeAvatar,
        submitProfile,
        resetForm,
        setAvatarInputRef,
    };
});
