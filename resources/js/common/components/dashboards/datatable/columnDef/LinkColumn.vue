<script setup lang="ts">
import { ExternalLink } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    value: string | null | undefined;
    href?: string;
    openInNewTab?: boolean;
    showIcon?: boolean;
    className?: string;
}

const props = withDefaults(defineProps<Props>(), {
    openInNewTab: false,
    showIcon: false,
});

const linkHref = computed(() => {
    return props.href || props.value || '#';
});

const linkTarget = computed(() => {
    return props.openInNewTab ? '_blank' : '_self';
});

const linkRel = computed(() => {
    return props.openInNewTab ? 'noopener noreferrer' : undefined;
});

const displayValue = computed(() => {
    if (!props.value) return '-';

    // Shorten long URLs for display
    if (props.value.length > 40) {
        return props.value.substring(0, 37) + '...';
    }

    return props.value;
});
</script>

<template>
    <div v-if="value" class="flex items-center gap-1.5">
        <a
            :href="linkHref"
            :target="linkTarget"
            :rel="linkRel"
            :class="[
                'text-primary hover:underline transition-colors',
                'focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 rounded',
                className
            ]"
        >
            {{ displayValue }}
        </a>
        <ExternalLink
            v-if="showIcon && openInNewTab"
            class="h-3.5 w-3.5 text-muted-foreground flex-shrink-0"
        />
    </div>
    <span v-else class="text-sm text-muted-foreground">-</span>
</template>
