<script setup lang="ts">
import RadioButton from 'primevue/radiobutton';
import { computed } from 'vue';

interface Props {
    /**
     * Radio value (v-model)
     */
    modelValue?: any;

    /**
     * Value to bind when selected
     */
    value: any;

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
     * Radio id
     */
    id?: string;

    /**
     * Name attribute for grouping
     */
    name?: string;

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

    /**
     * Helper text below radio
     */
    hint?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    label: '',
    error: null,
    disabled: false,
    required: false,
    id: undefined,
    name: undefined,
    labelPosition: 'right',
    class: '',
    showLabel: true,
    hint: '',
});

const emit = defineEmits<{
    'update:modelValue': [value: any];
    change: [event: Event];
}>();

// Computed class with error state
const radioClasses = computed(() => {
    const classes = [props.class];

    if (props.error) {
        classes.push('invalid-radio');
    }

    return classes.join(' ');
});

// Handle change event
const handleChange = (value: any) => {
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="space-y-1">
        <div class="flex items-center gap-2" :class="{ 'flex-row-reverse': labelPosition === 'left' }">
            <RadioButton
                :id="id"
                :model-value="modelValue"
                :value="value"
                :name="name"
                :disabled="disabled"
                :class="radioClasses"
                @update:model-value="handleChange"
            />
            <label
                v-if="showLabel && label"
                :for="id"
                class="cursor-pointer select-none text-sm font-medium leading-none text-foreground peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                :class="{ 'cursor-not-allowed opacity-70': disabled }"
            >
                {{ label }}
                <span v-if="required" class="text-destructive">*</span>
            </label>
        </div>
        <p v-if="hint" class="text-xs text-muted-foreground" :class="{ 'ml-7': labelPosition === 'right' }">
            {{ hint }}
        </p>
        <p v-if="error" class="text-xs text-destructive" :class="{ 'ml-7': labelPosition === 'right' }">
            {{ error }}
        </p>
    </div>
</template>

<style scoped>
/* Dark mode overrides */
.dark .p-radiobutton .p-radiobutton-box {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

.dark .p-radiobutton .p-radiobutton-box.p-checked {
    background-color: hsl(var(--primary)) !important;
    border-color: hsl(var(--primary)) !important;
}

/* Light mode overrides */
.p-radiobutton .p-radiobutton-box {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

.p-radiobutton .p-radiobutton-box.p-checked {
    background-color: hsl(var(--primary)) !important;
    border-color: hsl(var(--primary)) !important;
}

/* Error state for radio */
.invalid-radio .p-radiobutton-box {
    border-color: hsl(var(--destructive)) !important;
}

/* Focus state for radio */
.p-radiobutton:not(.p-disabled) .p-radiobutton-box:hover {
    border-color: hsl(var(--primary)) !important;
}

.p-radiobutton:not(.p-disabled) .p-radiobutton-box.p-focus {
    border-color: hsl(var(--primary)) !important;
    box-shadow: 0 0 0 2px hsl(var(--primary) / 0.2) !important;
}

/* Error focus state */
.invalid-radio .p-radiobutton-box.p-focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Disabled state */
.p-radiobutton.p-disabled .p-radiobutton-box {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Smooth transitions */
.p-radiobutton .p-radiobutton-box {
    transition: all 0.2s ease-in-out;
}
</style>
