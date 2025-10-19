<script setup lang="ts">
import Checkbox from 'primevue/checkbox';
import { computed } from 'vue';

interface Props {
    /**
     * Checkbox value (v-model)
     */
    modelValue?: boolean | any;

    /**
     * Value to bind when checked (for array binding)
     */
    value?: any;

    /**
     * Label text
     */
    label?: string;

    /**
     * Error message (when provided, shows red border)
     */
    error?: string | null;

    /**
     * Disabled state
     */
    disabled?: boolean;

    /**
     * Required attribute
     */
    required?: boolean;

    /**
     * Checkbox id
     */
    id?: string;

    /**
     * Binary mode (true/false only)
     * @default true
     */
    binary?: boolean;

    /**
     * Label position
     * @default 'right'
     */
    labelPosition?: 'left' | 'right';

    /**
     * Additional class names
     */
    class?: string;

    /**
     * Show label
     * @default true
     */
    showLabel?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: false,
    value: undefined,
    label: '',
    error: null,
    disabled: false,
    required: false,
    id: undefined,
    binary: true,
    labelPosition: 'right',
    class: '',
    showLabel: true,
});

const emit = defineEmits<{
    'update:modelValue': [value: boolean | any];
    change: [event: Event];
}>();

// Computed class with error state
const checkboxClasses = computed(() => {
    const classes = [props.class];

    if (props.error) {
        classes.push('invalid-checkbox');
    }

    return classes.join(' ');
});

// Handle change event
const handleChange = (value: boolean | any) => {
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="flex items-center gap-2" :class="{ 'flex-row-reverse': labelPosition === 'left' }">
        <Checkbox
            :id="id"
            :model-value="modelValue"
            :value="value"
            :disabled="disabled"
            :required="required"
            :binary="binary"
            :class="checkboxClasses"
            @update:model-value="handleChange"
        />
        <label
            v-if="showLabel && label"
            :for="id"
            class="cursor-pointer select-none text-sm font-medium leading-none text-foreground peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
            :class="{ 'cursor-not-allowed opacity-70': disabled }"
        >
            {{ label }}
        </label>
    </div>
</template>

<style scoped>
/* Dark mode overrides */
.dark .p-checkbox .p-checkbox-box {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

.dark .p-checkbox .p-checkbox-box.p-checked {
    background-color: hsl(var(--primary)) !important;
    border-color: hsl(var(--primary)) !important;
}

/* Light mode overrides */
.p-checkbox .p-checkbox-box {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

.p-checkbox .p-checkbox-box.p-checked {
    background-color: hsl(var(--primary)) !important;
    border-color: hsl(var(--primary)) !important;
}

/* Error state for checkbox */
.invalid-checkbox .p-checkbox-box {
    border-color: hsl(var(--destructive)) !important;
}

/* Focus state for checkbox */
.p-checkbox:not(.p-disabled) .p-checkbox-box:hover {
    border-color: hsl(var(--primary)) !important;
}

.p-checkbox:not(.p-disabled) .p-checkbox-box.p-focus {
    border-color: hsl(var(--primary)) !important;
    box-shadow: 0 0 0 2px hsl(var(--primary) / 0.2) !important;
}

/* Error focus state */
.invalid-checkbox .p-checkbox-box.p-focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Disabled state */
.p-checkbox.p-disabled .p-checkbox-box {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Smooth transitions */
.p-checkbox .p-checkbox-box {
    transition: all 0.2s ease-in-out;
}
</style>
