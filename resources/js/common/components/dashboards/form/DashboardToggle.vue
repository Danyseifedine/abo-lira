<script setup lang="ts">
import Switch from '@/shared/ui/switch/Switch.vue';
import { computed } from 'vue';

interface Props {
    /**
     * Toggle value (v-model)
     */
    modelValue?: boolean;

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
     * Toggle id
     */
    id?: string;

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
     * Helper text below toggle
     */
    hint?: string;

    /**
     * Switch size style
     * @default 'small'
     */
    size?: 'small' | 'medium' | 'large';
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: false,
    label: '',
    error: null,
    disabled: false,
    required: false,
    id: undefined,
    labelPosition: 'right',
    class: '',
    showLabel: true,
    hint: '',
    size: 'small',
});

const emit = defineEmits<{
    'update:modelValue': [value: boolean];
    change: [event: Event];
}>();

// Compute Tailwind size class for the Switch
const sizeClass = computed(() => {
    switch (props.size) {
        case 'small':
            return 'scale-75';
        case 'large':
            return 'scale-125';
        case 'medium':
        default:
            return 'scale-100';
    }
});

// Computed class with error state and size
const toggleClasses = computed(() => {
    const classes = [props.class];

    if (props.error) {
        classes.push('invalid-toggle');
    }

    if (sizeClass.value) {
        classes.push(sizeClass.value);
    }

    return classes.join(' ');
});

// Handle change event
const handleChange = (value: boolean) => {
    emit('update:modelValue', value);
};
</script>

<template>
    <div class="space-y-1">
        <div class="flex items-center gap-3" :class="{ 'flex-row-reverse justify-end': labelPosition === 'left' }">
            <Switch :id="id" :model-value="modelValue" :disabled="disabled" :class="toggleClasses" @update:model-value="handleChange" />
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
        <p v-if="hint" class="text-xs text-muted-foreground" :class="{ 'ml-12': labelPosition === 'right' }">
            {{ hint }}
        </p>
        <p v-if="error" class="text-xs text-destructive" :class="{ 'ml-12': labelPosition === 'right' }">
            {{ error }}
        </p>
    </div>
</template>

<style scoped>
/* Dark mode overrides */
.dark .p-switch .p-switch-slider {
    background-color: #262626 !important;
}

.dark .p-switch.p-switch-checked .p-switch-slider {
    background-color: hsl(var(--primary)) !important;
}

/* Light mode overrides */
.p-switch .p-switch-slider {
    background-color: #e4e4e4 !important;
}

.p-switch.p-switch-checked .p-switch-slider {
    background-color: hsl(var(--primary)) !important;
}

/* Error state for toggle */
.invalid-toggle .p-switch-slider {
    border: 2px solid hsl(var(--destructive)) !important;
}

/* Focus state for toggle */
.p-switch:not(.p-disabled):hover .p-switch-slider {
    background-color: #d4d4d4 !important;
}

.dark .p-switch:not(.p-disabled):hover .p-switch-slider {
    background-color: #404040 !important;
}

.p-switch.p-switch-checked:not(.p-disabled):hover .p-switch-slider {
    background-color: hsl(var(--primary) / 0.9) !important;
}

.p-switch .p-switch-slider:focus-visible {
    box-shadow: 0 0 0 2px hsl(var(--primary) / 0.2) !important;
    outline: none !important;
}

/* Error focus state */
.invalid-toggle .p-switch-slider:focus-visible {
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Disabled state */
.p-switch.p-disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Smooth transitions */
.p-switch .p-switch-slider {
    transition: all 0.2s ease-in-out;
}
</style>
