<script setup lang="ts">
import { computed } from 'vue';
import { __ } from '@/core/utils/translations';

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

            if (days === 0) return __('datatable.today');
            if (days === 1) return __('datatable.yesterday');
            if (days < 7) return `${days} ${__('datatable.days_ago')}`;
            if (days < 30) return `${Math.floor(days / 7)} ${__('datatable.weeks_ago')}`;
            if (days < 365) return `${Math.floor(days / 30)} ${__('datatable.months_ago')}`;
            return `${Math.floor(days / 365)} ${__('datatable.years_ago')}`;
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
