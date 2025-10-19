<script setup lang="ts">
import InputText from 'primevue/inputtext';
import { computed } from 'vue';

interface Props {
    /**
     * Input value (v-model)
     */
    modelValue?: string | number | null;

    /**
     * Input type
     */
    type?: 'text' | 'email' | 'password' | 'number' | 'tel' | 'url';

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
     * Additional class names
     */
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: '',
    type: 'text',
    placeholder: '',
    error: null,
    disabled: false,
    required: false,
    autofocus: false,
    id: undefined,
    size: 'small',
    fluid: true,
    class: '',
});

const emit = defineEmits<{
    'update:modelValue': [value: string | number];
    blur: [event: FocusEvent];
    focus: [event: FocusEvent];
}>();

// Computed class with error state
const inputClasses = computed(() => {
    const classes = [props.class];

    if (props.error) {
        classes.push('invalid-input-text');
    }

    classes.push('input-text-no-border');

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
    <InputText
        :id="id"
        :model-value="modelValue as string"
        :type="type"
        :placeholder="placeholder"
        :disabled="disabled"
        :required="required"
        :autofocus="autofocus"
        :size="size"
        :fluid="fluid"
        :class="inputClasses"
        @input="handleInput"
        @blur="handleBlur"
        @focus="handleFocus"
    />
</template>

<style scoped>
/* Dark mode overrides */
.dark .p-inputtext {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

/* Light mode overrides */
.p-inputtext {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

/* Error state for input text - must come after normal state for specificity */
.p-inputtext.invalid-input-text,
.invalid-input-text.p-inputtext {
    border-color: hsl(var(--destructive)) !important;
    background-color: transparent !important;
}

/* Focus state for input text */
.p-inputtext.invalid-input-text:focus,
.invalid-input-text.p-inputtext:focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Dark mode error state for input text */
.dark .p-inputtext.invalid-input-text,
.dark .invalid-input-text.p-inputtext {
    border-color: hsl(var(--destructive)) !important;
}
</style>
