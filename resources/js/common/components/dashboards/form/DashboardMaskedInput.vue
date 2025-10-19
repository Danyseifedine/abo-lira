<script setup lang="ts">
import Password from 'primevue/password';
import { computed } from 'vue';

interface Props {
    /**
     * Input value (v-model)
     */
    modelValue?: string | null;

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
     * Required attribute
     */
    required?: boolean;

    /**
     * Autofocus
     */
    autofocus?: boolean;

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
     * Show/hide password toggle button
     * @default false
     */
    toggleMask?: boolean;

    /**
     * Show strength meter
     * @default false
     */
    showStrength?: boolean;

    /**
     * Additional class names
     */
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: '',
    placeholder: '',
    error: null,
    disabled: false,
    required: false,
    autofocus: false,
    id: undefined,
    size: 'small',
    fluid: true,
    toggleMask: false,
    showStrength: false,
    class: '',
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
    blur: [event: FocusEvent];
    focus: [event: FocusEvent];
}>();

// Computed class for the wrapper
const wrapperClass = computed(() => {
    const classes: string[] = ['password-wrapper'];

    if (props.class) {
        classes.push(props.class);
    }

    if (props.error) {
        classes.push('has-error');
    }

    return classes.join(' ');
});

// Handle input event
const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    emit('update:modelValue', target.value);
};

// Handle blur event
const handleBlur = (event: FocusEvent) => {
    emit('blur', event);
};

// Handle focus event
const handleFocus = (event: FocusEvent) => {
    emit('focus', event);
};
</script>

<template>
    <div :class="wrapperClass">
        <Password
            :id="id"
            :model-value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :required="required"
            :autofocus="autofocus"
            :toggleMask="toggleMask"
            :feedback="showStrength"
            :fluid="fluid"
            :size="size"
            @input="handleInput"
            @blur="handleBlur"
            @focus="handleFocus"
        />
    </div>
</template>

<style>
/* Global styles for this component's password inputs */
.password-wrapper .p-password input {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

/* Dark mode overrides */
.dark .password-wrapper .p-password input {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

/* Error state for input */
.password-wrapper.has-error .p-password input {
    border-color: hsl(var(--destructive)) !important;
}

/* Focus state for error inputs */
.password-wrapper.has-error .p-password input:focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Toggle mask button styles if needed */
.password-wrapper .p-password .p-password-toggle-mask {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

.dark .password-wrapper .p-password .p-password-toggle-mask {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}
</style>
