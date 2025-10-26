<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import MultiSelect from 'primevue/multiselect';
import { computed } from 'vue';

interface Props {
    /**
     * Selected values (v-model)
     */
    modelValue?: any[] | null;

    /**
     * Array of options
     */
    options: any[];

    /**
     * Property name to use as the label
     * @default 'label'
     */
    optionLabel?: string;

    /**
     * Property name to use as the value
     * @default 'value'
     */
    optionValue?: string;

    /**
     * Auto-localized label - automatically switches between name_en and name_ar based on locale
     * @default false
     */
    autoLocalizedLabel?: boolean;

    /**
     * Property name for option group label
     */
    optionGroupLabel?: string;

    /**
     * Property name for option group children
     */
    optionGroupChildren?: string;

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
     * Display mode
     * @default 'chip'
     */
    display?: 'comma' | 'chip';

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
     * Show toggle all checkbox
     * @default true
     */
    showToggleAll?: boolean;

    /**
     * Maximum number of selected labels to show
     */
    maxSelectedLabels?: number;

    /**
     * Text to display when more items are selected than maxSelectedLabels
     */
    selectedItemsLabel?: string;

    /**
     * Additional class names
     */
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    optionLabel: 'label',
    optionValue: 'value',
    autoLocalizedLabel: false,
    placeholder: 'Select items',
    error: null,
    disabled: false,
    display: 'chip',
    showClear: true,
    filter: false,
    filterPlaceholder: 'Search...',
    scrollHeight: '200px',
    id: undefined,
    size: 'small',
    fluid: true,
    showToggleAll: true,
    maxSelectedLabels: 3,
    selectedItemsLabel: '{0} items selected',
    class: '',
});

const page = usePage();

const emit = defineEmits<{
    'update:modelValue': [value: any[]];
    change: [event: any];
    blur: [event: Event];
    focus: [event: Event];
}>();

// Computed option label - auto-localizes if enabled
const computedOptionLabel = computed(() => {
    if (props.autoLocalizedLabel) {
        return page.props.locale === 'ar' ? 'name_ar' : 'name_en';
    }
    return props.optionLabel;
});

// Computed class with error state
const wrapperClass = computed(() => {
    const classes = ['multiselect-wrapper'];

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
        <MultiSelect
            :id="id"
            :model-value="modelValue"
            :options="options"
            :option-label="computedOptionLabel"
            :option-value="optionValue"
            :option-group-label="optionGroupLabel"
            :option-group-children="optionGroupChildren"
            :placeholder="placeholder"
            :disabled="disabled"
            :display="display"
            :show-clear="showClear"
            :filter="filter"
            :filter-placeholder="filterPlaceholder"
            :scroll-height="scrollHeight"
            :size="size"
            :fluid="fluid"
            :show-toggle-all="showToggleAll"
            :max-selected-labels="maxSelectedLabels"
            :selected-items-label="selectedItemsLabel"
            @change="handleChange"
            @blur="handleBlur"
            @focus="handleFocus"
        >
            <!-- Pass through slots -->
            <template v-for="(_, slot) in $slots" #[slot]="slotProps">
                <slot :name="slot" v-bind="slotProps" />
            </template>
        </MultiSelect>
    </div>
</template>

<style>
/* Base multiselect styles */
.multiselect-wrapper .p-multiselect {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
    min-height: 2.5rem !important;
    height: auto !important;
}

/* Dark mode multiselect */
.dark .multiselect-wrapper .p-multiselect {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

/* Focus state for multiselect - light mode */
.multiselect-wrapper .p-multiselect.p-focus {
    border-color: hsl(var(--ring)) !important;
    box-shadow: 0 0 0 2px hsl(var(--ring) / 0.2) !important;
}

/* Dark mode focus */
.dark .multiselect-wrapper .p-multiselect.p-focus {
    border-color: hsl(var(--ring)) !important;
    box-shadow: 0 0 0 2px hsl(var(--ring) / 0.2) !important;
}

/* Hover state for multiselect */
.multiselect-wrapper .p-multiselect:not(.p-disabled):hover {
    border-color: hsl(var(--input)) !important;
}

/* Error state for multiselect */
.multiselect-wrapper.has-error .p-multiselect {
    border-color: hsl(var(--destructive)) !important;
}

/* Focus state for multiselect with error */
.multiselect-wrapper.has-error .p-multiselect:focus,
.multiselect-wrapper.has-error .p-multiselect.p-focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Dark mode error state */
.dark .multiselect-wrapper.has-error .p-multiselect {
    border-color: hsl(var(--destructive)) !important;
}

/* Label inside multiselect */
.multiselect-wrapper .p-multiselect-label {
    padding: 0.5rem 0.75rem !important;
    color: hsl(var(--foreground)) !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 0.25rem !important;
    align-items: center !important;
}

/* Placeholder */
.multiselect-wrapper .p-multiselect-label.p-placeholder {
    color: hsl(var(--muted-foreground)) !important;
}

/* Trigger icon */
.multiselect-wrapper .p-multiselect-trigger {
    color: hsl(var(--muted-foreground)) !important;
}
</style>

<!-- Global styles for dropdown panel and chips -->
<style>
/* Dropdown panel itself */
.p-multiselect-overlay {
    border: 1px solid hsl(var(--border)) !important;
    background: hsl(var(--background)) !important;
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.1),
        0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
}

/* Dark mode dropdown panel */
.dark .p-multiselect-overlay {
    border: 1px solid hsl(var(--border)) !important;
    background: hsl(var(--background)) !important;
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.4),
        0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
}

/* Header with toggle all */
.p-multiselect-header {
    padding: 0.5rem !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
    background: transparent !important;
}

/* Toggle all checkbox container */
.p-multiselect-select-all {
    padding: 0.375rem 0.75rem !important;
}

/* Filter container */
.p-multiselect-filter-container {
    padding: 0.5rem !important;
    background: transparent !important;
}

/* Filter input - ALWAYS show bottom border */
.p-multiselect-filter {
    width: 100% !important;
    background-color: transparent !important;
    border: none !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
    border-radius: 0 !important;
    padding: 0.5rem 0 !important;
    margin: 0 !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    box-shadow: none !important;
    outline: none !important;
    transition: border-color 0.2s ease !important;
}

/* Filter input placeholder */
.p-multiselect-filter::placeholder {
    color: hsl(var(--muted-foreground)) !important;
}

/* Filter input ALL states - maintain bottom border */
.p-multiselect-filter:hover,
.p-multiselect-filter:focus,
.p-multiselect-filter:active,
.p-multiselect-filter:focus-visible {
    background-color: transparent !important;
    border: none !important;
    border-bottom: 1px solid hsl(var(--primary)) !important;
    box-shadow: none !important;
    outline: none !important;
}

/* Ensure border stays even when blurred */
.p-multiselect-filter:not(:focus) {
    border: none !important;
    border-bottom: 1px solid hsl(var(--border)) !important;
}

/* Dark mode filter input */
.dark .p-multiselect-filter {
    border-bottom: 1px solid hsl(var(--border)) !important;
    color: hsl(var(--foreground)) !important;
}

/* List container */
.p-multiselect-list {
    padding: 0.25rem !important;
}

/* Option group */
.p-multiselect-option-group {
    padding: 0.5rem 0.75rem !important;
    font-weight: 600 !important;
    color: hsl(var(--muted-foreground)) !important;
    font-size: 0.75rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
}

/* Individual option */
.p-multiselect-option {
    padding: 0.375rem 0.75rem !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    border-radius: 0.25rem !important;
    margin: 0.125rem 0 !important;
    transition: all 0.15s ease !important;
    display: flex !important;
    align-items: center !important;
}

/* Default option state */
.p-multiselect-option:not([data-p-disabled='true']) {
    background-color: transparent !important;
    color: hsl(var(--foreground)) !important;
}

/* Hover state for options */
.p-multiselect-option:not([data-p-disabled='true']):not([data-p-focused='true']):hover {
    background-color: hsl(var(--muted)) !important;
    color: hsl(var(--foreground)) !important;
}

/* Focused option (keyboard navigation) */
.p-multiselect-option[data-p-focused='true']:not([aria-selected='true']) {
    background-color: hsl(var(--muted)) !important;
    color: hsl(var(--foreground)) !important;
}

/* Selected option - Light mode */
.p-multiselect-option[aria-selected='true'],
.p-multiselect-option[data-p-highlight='true'] {
    background-color: hsl(var(--primary) / 0.1) !important;
    color: hsl(var(--primary)) !important;
}

/* Selected option hover - Light mode */
.p-multiselect-option[aria-selected='true']:hover,
.p-multiselect-option[data-p-highlight='true']:hover {
    background-color: hsl(var(--primary) / 0.15) !important;
    color: hsl(var(--primary)) !important;
}

/* Dark mode - Selected option */
.dark .p-multiselect-option[aria-selected='true'],
.dark .p-multiselect-option[data-p-highlight='true'] {
    background-color: hsl(var(--primary) / 0.2) !important;
    color: hsl(var(--primary)) !important;
}

/* Dark mode - Selected option hover */
.dark .p-multiselect-option[aria-selected='true']:hover,
.dark .p-multiselect-option[data-p-highlight='true']:hover {
    background-color: hsl(var(--primary) / 0.25) !important;
    color: hsl(var(--primary)) !important;
}

/* Checkbox inside options */
.p-multiselect-option .p-checkbox {
    margin-right: 0.5rem !important;
}

.p-multiselect-option .p-checkbox-box {
    width: 1rem !important;
    height: 1rem !important;
    border: 1px solid hsl(var(--border)) !important;
    background: transparent !important;
    border-radius: 0.25rem !important;
}

/* Checked checkbox */
.p-multiselect-option .p-checkbox-checked .p-checkbox-box {
    background-color: hsl(var(--primary)) !important;
    border-color: hsl(var(--primary)) !important;
}

.p-multiselect-option .p-checkbox-icon {
    color: hsl(var(--primary-foreground)) !important;
    font-size: 0.625rem !important;
}

/* Chips display mode */
.p-multiselect-chip {
    background-color: hsl(var(--secondary)) !important;
    color: hsl(var(--secondary-foreground)) !important;
    padding: 0.125rem 0.375rem !important;
    border-radius: 0.25rem !important;
    margin: 0 !important;
    font-size: 0.75rem !important;
    display: inline-flex !important;
    align-items: center !important;
    flex-shrink: 0 !important;
}

/* Chip remove icon */
.p-multiselect-chip-remove-icon {
    margin-left: 0.25rem !important;
    width: 0.75rem !important;
    height: 0.75rem !important;
    cursor: pointer !important;
    opacity: 0.7 !important;
    transition: opacity 0.15s ease !important;
}

.p-multiselect-chip-remove-icon:hover {
    opacity: 1 !important;
}

/* Dark mode chips */
.dark .p-multiselect-chip {
    background-color: hsl(var(--secondary)) !important;
    color: hsl(var(--secondary-foreground)) !important;
}

/* Empty message */
.p-multiselect-empty-message {
    padding: 0.5rem 0.75rem !important;
    color: hsl(var(--muted-foreground)) !important;
    font-size: 0.875rem !important;
    text-align: center !important;
}

/* Close button */
.p-multiselect-close {
    color: hsl(var(--muted-foreground)) !important;
    width: 1.25rem !important;
    height: 1.25rem !important;
}

.p-multiselect-close:hover {
    color: hsl(var(--foreground)) !important;
}

/* Disabled state */
.p-multiselect-option[data-p-disabled='true'] {
    opacity: 0.5 !important;
    cursor: not-allowed !important;
}

/* Size variants */
.multiselect-wrapper .p-multiselect.p-multiselect-sm {
    min-height: 2rem !important;
}

.multiselect-wrapper .p-multiselect.p-multiselect-sm .p-multiselect-label {
    padding: 0.375rem 0.625rem !important;
    font-size: 0.875rem !important;
}

.multiselect-wrapper .p-multiselect.p-multiselect-lg {
    min-height: 3rem !important;
}

.multiselect-wrapper .p-multiselect.p-multiselect-lg .p-multiselect-label {
    padding: 0.625rem 0.875rem !important;
    font-size: 1rem !important;
}
</style>
