<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    value: string | Date | null;
    format?: string;
    relative?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    format: 'MMM dd, yyyy',
    relative: false,
});

const formatted = computed(() => {
    if (!props.value) return '-';

    try {
        const date = new Date(props.value);

        if (props.relative) {
            // Simple relative time (you can use date-fns or dayjs for better formatting)
            const now = new Date();
            const diff = now.getTime() - date.getTime();
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));

            if (days === 0) return 'Today';
            if (days === 1) return 'Yesterday';
            if (days < 7) return `${days} days ago`;
            if (days < 30) return `${Math.floor(days / 7)} weeks ago`;
            if (days < 365) return `${Math.floor(days / 30)} months ago`;
            return `${Math.floor(days / 365)} years ago`;
        }

        // Simple date formatting
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        });
    } catch {
        return String(props.value);
    }
});
</script>

<template>
    <span class="text-sm">{{ formatted }}</span>
</template>
