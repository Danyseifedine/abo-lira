<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    value: string;
    showCode?: boolean;
    swatchSize?: 'sm' | 'md' | 'lg';
}

const props = withDefaults(defineProps<Props>(), {
    showCode: true,
    swatchSize: 'md',
});

const sizeClasses = computed(() => {
    switch (props.swatchSize) {
        case 'sm':
            return 'h-5 w-5';
        case 'lg':
            return 'h-8 w-8';
        case 'md':
        default:
            return 'h-6 w-6';
    }
});
</script>

<template>
    <div class="flex items-center gap-2">
        <div :class="['rounded border border-gray-300 dark:border-gray-600', sizeClasses]" :style="{ backgroundColor: value }" :title="value" />
    </div>
</template>
