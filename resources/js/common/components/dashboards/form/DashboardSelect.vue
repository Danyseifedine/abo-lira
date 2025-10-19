<script setup lang="ts">
import Select from 'primevue/select';
import { computed } from 'vue';

interface Props {
    /**
     * Selected value (v-model)
     */
    modelValue?: string | number | boolean | null;

    /**
     * Array of options
     */
    options: any[];

    /**
     * Property name to use as the label
     * @default 'name'
     */
    optionLabel?: string;

    /**
     * Property name to use as the value
     * @default 'code'
     */
    optionValue?: string;

    /**
     * Placeholder text
     */
    placeholder?: string;

    /**
     * Error message (when provided, shows red border)
     */
    error?: string | null;

    /**
     * Disabled state
     */
    disabled?: boolean;

    /**
     * Show clear button
     * @default true
     */
    showClear?: boolean;

    /**
     * Enable filtering/search
     * @default false
     */
    filter?: boolean;

    /**
     * Filter placeholder text
     */
    filterPlaceholder?: string;

    /**
     * Scroll height for dropdown
     * @default '200px'
     */
    scrollHeight?: string;

    /**
     * Input id
     */
    id?: string;

    /**
     * Size variant
     * @default 'small'
     */
    size?: 'small' | 'large';

    /**
     * Fluid (full width)
     * @default true
     */
    fluid?: boolean;

    /**
     * Additional class names
     */
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    optionLabel: 'name',
    optionValue: 'code',
    placeholder: 'Select an option',
    error: null,
    disabled: false,
    showClear: true,
    filter: false,
    filterPlaceholder: 'Search...',
    scrollHeight: '200px',
    id: undefined,
    size: 'small',
    fluid: true,
    class: '',
});

const emit = defineEmits<{
    'update:modelValue': [value: string | number | null];
    change: [event: any];
    blur: [event: Event];
    focus: [event: Event];
}>();

// Computed class with error state
const wrapperClass = computed(() => {
    const classes = ['select-wrapper'];

    if (props.class) {
        classes.push(props.class);
    }

    if (props.error) {
        classes.push('has-error');
    }

    return classes.join(' ');
});

// Handle change event
const handleChange = (event: any) => {
    emit('update:modelValue', event.value);
    emit('change', event);
};

// Handle blur event
const handleBlur = (event: Event) => {
    emit('blur', event);
};

// Handle focus event
const handleFocus = (event: Event) => {
    emit('focus', event);
};
</script>

<template>
    <div :class="wrapperClass">
        <Select
            :id="id"
            :model-value="modelValue"
            :options="options"
            :option-label="optionLabel"
            :option-value="optionValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :show-clear="showClear"
            :filter="filter"
            :filter-placeholder="filterPlaceholder"
            :scroll-height="scrollHeight"
            :size="size"
            :fluid="fluid"
            @change="handleChange"
            @blur="handleBlur"
            @focus="handleFocus"
        />
    </div>
</template>

<style>
/* Base select styles */
.select-wrapper .p-select {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

/* Dark mode select */
.dark .select-wrapper .p-select {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

/* Focus state for select - light mode */
.select-wrapper .p-select.p-focus {
    border-color: hsl(var(--ring)) !important;
    box-shadow: 0 0 0 2px hsl(var(--ring) / 0.2) !important;
}

/* Focus state for select - dark mode */
.dark .select-wrapper .p-select.p-focus {
    border-color: hsl(var(--ring)) !important;
    box-shadow: 0 0 0 2px hsl(var(--ring) / 0.2) !important;
}

/* Hover state for select */
.select-wrapper .p-select:not(.p-disabled):hover {
    border-color: hsl(var(--input)) !important;
}

/* Error state for select */
.select-wrapper.has-error .p-select {
    border-color: hsl(var(--destructive)) !important;
}

/* Focus state for select with error */
.select-wrapper.has-error .p-select:focus,
.select-wrapper.has-error .p-select.p-focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Dark mode error state */
.dark .select-wrapper.has-error .p-select {
    border-color: hsl(var(--destructive)) !important;
}
</style>

<!-- Global styles for dropdown panel (can't be scoped) -->
<style>
/* Dropdown panel itself */
.p-select-overlay {
    border: 1px solid hsl(var(--border)) !important;
    background: hsl(var(--background)) !important;
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.1),
        0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
}

/* Dark mode dropdown panel */
.dark .p-select-overlay {
    border: 1px solid hsl(var(--border)) !important;
    background: hsl(var(--background)) !important;
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.4),
        0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

/* List container inside dropdown */
.p-select-list {
    padding: 0.25rem !important;
}

/* Dropdown panel options */
.p-select-option {
    padding: 0.375rem 0.75rem !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    border-radius: 0.25rem !important;
    margin: 0.125rem 0 !important;
    transition: all 0.15s ease !important;
}

/* Default option state */
.p-select-option:not([data-p-disabled='true']) {
    background-color: transparent !important;
    color: hsl(var(--foreground)) !important;
}

/* Hover state for options */
.p-select-option:not([data-p-disabled='true']):not([data-p-focused='true']):hover {
    background-color: hsl(var(--muted)) !important;
    color: hsl(var(--foreground)) !important;
}

/* Focused option (keyboard navigation) */
.p-select-option[data-p-focused='true']:not([aria-selected='true']) {
    background-color: hsl(var(--muted)) !important;
    color: hsl(var(--foreground)) !important;
}

/* Selected option - Light mode */
.p-select-option[aria-selected='true'],
.p-select-option[data-p-highlight='true'] {
    background-color: hsl(var(--primary) / 0.08) !important;
    color: hsl(var(--primary)) !important;
    font-weight: 500 !important;
}

/* Selected option hover - Light mode */
.p-select-option[aria-selected='true']:hover,
.p-select-option[data-p-highlight='true']:hover {
    background-color: hsl(var(--primary) / 0.12) !important;
    color: hsl(var(--primary)) !important;
}

/* Dark mode - Selected option */
.dark .p-select-option[aria-selected='true'],
.dark .p-select-option[data-p-highlight='true'] {
    background-color: hsl(var(--primary) / 0.15) !important;
    color: hsl(var(--primary)) !important;
    font-weight: 500 !important;
}

/* Dark mode - Selected option hover */
.dark .p-select-option[aria-selected='true']:hover,
.dark .p-select-option[data-p-highlight='true']:hover {
    background-color: hsl(var(--primary) / 0.2) !important;
    color: hsl(var(--primary)) !important;
}

/* Filter container */
.p-select-filter-container {
    border: none !important;
    box-shadow: none !important;
    padding: 0.5rem !important;
    background: transparent !important;
}

/* Filter input inside dropdown - ALWAYS show bottom border */
.p-select-filter {
    width: 100% !important;
    background-color: transparent !important;
    border: none !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
    border-radius: 0 !important;
    padding: 0.5rem 0 !important;
    margin: 0 0 0.5rem 0 !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    box-shadow: none !important;
    outline: none !important;
    transition: border-color 0.2s ease !important;
}

/* Filter input placeholder */
.p-select-filter::placeholder {
    color: hsl(var(--muted-foreground)) !important;
}

/* Filter input ALL states - maintain bottom border */
.p-select-filter:hover,
.p-select-filter:focus,
.p-select-filter:active,
.p-select-filter:focus-visible {
    background-color: transparent !important;
    border: none !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
    box-shadow: none !important;
    outline: none !important;
}

/* Ensure border stays even when blurred */
.p-select-filter:not(:focus) {
    border: none !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
}

/* Dark mode filter input */
.dark .p-select-filter {
    border-bottom: 1px solid hsl(var(--border)) !important;
    color: hsl(var(--foreground)) !important;
}

/* Dark mode filter input focus */
.dark .p-select-filter:hover,
.dark .p-select-filter:focus,
.dark .p-select-filter:active,
.dark .p-select-filter:focus-visible {
    border: none !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
}

/* Dark mode filter input not focused */
.dark .p-select-filter:not(:focus) {
    border: none !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
}

/* Disabled option */
.p-select-option[data-p-disabled='true'] {
    opacity: 0.5 !important;
    cursor: not-allowed !important;
    background-color: transparent !important;
}

/* Empty message */
.p-select-empty-message {
    padding: 0.5rem 0.75rem !important;
    color: hsl(var(--muted-foreground)) !important;
    font-size: 0.875rem !important;
    text-align: center !important;
}
</style>
