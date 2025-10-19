<script setup lang="ts">
import { Button, type ButtonVariants } from '@ui/button';
import { CircleDot, Cog, Disc3, Loader2, LoaderCircle, RefreshCw, RotateCw } from 'lucide-vue-next';
import { computed, useSlots } from 'vue';

interface Props {
    /**
     * Button visual style variant
     */
    variant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link' | 'success' | 'warning' | 'gradient' | 'glass';

    /**
     * Button size - xs and xl are custom sizes
     */
    size?: 'xs' | 'sm' | 'default' | 'lg' | 'xl' | 'icon';

    /**
     * Show loading state with spinner
     */
    loading?: boolean;

    /**
     * Custom loading text - if not provided, uses button's default text
     */
    loadingText?: string;

    /**
     * Position of loading icon relative to text
     */
    loadingPosition?: 'before' | 'after';

    /**
     * Loading spinner icon type - 'none' shows text only
     */
    loadingIcon?: 'circle' | 'spinner' | 'rotate' | 'refresh' | 'gear' | 'dot' | 'disc' | 'none';

    /**
     * Additional CSS classes
     */
    class?: string;

    /**
     * Disable button interaction
     */
    disabled?: boolean;

    /**
     * HTML button type attribute
     */
    type?: 'button' | 'submit' | 'reset';
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
    size: 'default',
    loading: false,
    loadingPosition: 'after',
    loadingIcon: 'circle',
    type: 'button',
    class: '',
    disabled: false,
    loadingText: undefined,
});

const slots = useSlots();
const isDisabled = computed(() => props.disabled || props.loading);

// Smart loading text - uses default slot content if no loadingText provided
const displayLoadingText = computed(() => {
    if (props.loadingText) return props.loadingText;

    // Extract text from default slot
    const defaultSlot = slots.default?.();
    if (defaultSlot?.[0]?.children) {
        const text = defaultSlot[0].children as string;
        // If it's just whitespace or empty, return null to show no text
        return text.trim() || null;
    }

    // If no default slot content, return null (no text)
    return null;
});

// Get loading icon component
const getLoadingIcon = computed(() => {
    switch (props.loadingIcon) {
        case 'circle':
            return LoaderCircle;
        case 'spinner':
            return Loader2;
        case 'rotate':
            return RotateCw;
        case 'refresh':
            return RefreshCw;
        case 'gear':
            return Cog;
        case 'dot':
            return CircleDot;
        case 'disc':
            return Disc3;
        case 'none':
            return null;
        default:
            return LoaderCircle;
    }
});

// Custom variant styles
const customVariantClasses = computed(() => {
    switch (props.variant) {
        case 'success':
            return 'bg-green-600 hover:bg-green-700 text-white border-green-600 hover:border-green-700';
        case 'warning':
            return 'bg-orange-500 hover:bg-orange-600 text-white border-orange-500 hover:border-orange-600';
        case 'gradient':
            return 'bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 text-primary-foreground border-0 shadow-lg hover:shadow-xl';
        case 'glass':
            return 'bg-black/5 backdrop-blur-md border border-black/10 hover:bg-black/10 text-foreground shadow-lg hover:shadow-xl dark:bg-white/10 dark:border-white/20 dark:hover:bg-white/20';
        default:
            return '';
    }
});

// Custom size styles - using more specific selectors to override base classes
const customSizeClasses = computed(() => {
    switch (props.size) {
        case 'xs':
            return 'h-7 px-2 py-1 text-xs [&]:h-7 [&]:px-2 [&]:py-1 [&]:text-xs';
        case 'xl':
            return 'h-12 px-10 py-3 text-base font-medium [&]:h-12 [&]:px-10 [&]:py-3 [&]:text-base';
        default:
            return '';
    }
});

defineSlots<{
    /** Button content (text, elements) */
    default(): any;
    /** Icon to display alongside text (shows only when not loading) */
    icon?(): any;
}>();
</script>

<template>
    <Button
            :variant="(['success', 'warning', 'gradient', 'glass'].includes(variant) ? 'default' : variant) as ButtonVariants['variant']"
        :size="(['xs', 'xl'].includes(size) ? 'default' : size) as ButtonVariants['size']"
        :type="type"
        :disabled="isDisabled"
        :class="[
            'relative transition-all duration-200 disabled:cursor-not-allowed',
            customVariantClasses,
            customSizeClasses,
            props.class
        ]"
    >
        <!-- Loading state -->
        <template v-if="loading">
            <template v-if="loadingPosition === 'before'">
                <component
                    v-if="getLoadingIcon"
                    :is="getLoadingIcon"
                    :class="[
                        'animate-spin',
                        displayLoadingText ? 'mr-2' : '',
                        size === 'xs' ? 'h-3 w-3' : size === 'xl' ? 'h-5 w-5' : 'h-4 w-4'
                    ]"
                />
                <span v-if="displayLoadingText">{{ displayLoadingText }}</span>
            </template>
            <template v-else>
                <span v-if="displayLoadingText">{{ displayLoadingText }}</span>
                <component
                    v-if="getLoadingIcon"
                    :is="getLoadingIcon"
                    :class="[
                        'animate-spin',
                        displayLoadingText ? 'ml-2' : '',
                        size === 'xs' ? 'h-3 w-3' : size === 'xl' ? 'h-5 w-5' : 'h-4 w-4'
                    ]"
                />
            </template>
        </template>

        <!-- Default state -->
        <template v-else>
            <!-- Optional icon slot -->
            <slot name="icon" />
            <slot />
        </template>
    </Button>
</template>
