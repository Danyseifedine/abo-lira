<script setup lang="ts">
import { computed, ref } from 'vue';

interface Props {
    value: string | null | undefined;
    fallback?: string;
    size?: 'sm' | 'md' | 'lg';
    shape?: 'circle' | 'square' | 'rounded';
    alt?: string;
}

const props = withDefaults(defineProps<Props>(), {
    fallback: '/images/default-avatar.png',
    size: 'md',
    shape: 'circle',
    alt: 'Image',
});

const imageError = ref(false);

const imageSrc = computed(() => {
    if (imageError.value || !props.value) {
        return props.fallback;
    }
    return props.value;
});

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'h-8 w-8';
        case 'lg':
            return 'h-16 w-16';
        default:
            return 'h-10 w-10';
    }
});

const shapeClasses = computed(() => {
    switch (props.shape) {
        case 'circle':
            return 'rounded-full';
        case 'square':
            return 'rounded-none';
        default:
            return 'rounded-md';
    }
});

const handleError = () => {
    imageError.value = true;
};
</script>

<template>
    <div class="flex items-center">
        <img
            :src="imageSrc"
            :alt="alt"
            :class="[sizeClasses, shapeClasses, 'object-cover border border-border']"
            @error="handleError"
        />
    </div>
</template>
