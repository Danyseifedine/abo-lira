<script setup lang="ts">
import Textarea from 'primevue/textarea';
import { computed } from 'vue';

interface Props {
    /**
     * Textarea value (v-model)
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
     * Textarea id
     */
    id?: string;

    /**
     * Number of visible text lines
     * @default 3
     */
    rows?: number;

    /**
     * Auto resize textarea based on content
     * @default false
     */
    autoResize?: boolean;

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
    placeholder: '',
    error: null,
    disabled: false,
    required: false,
    autofocus: false,
    id: undefined,
    rows: 3,
    autoResize: false,
    fluid: true,
    class: '',
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
    blur: [event: FocusEvent];
    focus: [event: FocusEvent];
}>();

// Computed class with error state
const textareaClasses = computed(() => {
    const classes = [props.class];

    if (props.error) {
        classes.push('invalid-textarea');
    }

    classes.push('textarea-no-border');

    return classes.join(' ');
});

// Handle input event
const handleInput = (event: Event) => {
    const target = event.target as HTMLTextAreaElement;
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
    <Textarea
        :id="id"
        :model-value="modelValue as string"
        :placeholder="placeholder"
        :disabled="disabled"
        :required="required"
        :autofocus="autofocus"
        :rows="rows"
        :autoResize="autoResize"
        :fluid="fluid"
        :class="textareaClasses"
        @input="handleInput"
        @blur="handleBlur"
        @focus="handleFocus"
    />
</template>

<style scoped>
/* Dark mode overrides */
.dark .p-textarea {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

/* Light mode overrides */
.p-textarea {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

/* Error state for textarea - must come after normal state for specificity */
.p-textarea.invalid-textarea,
.invalid-textarea.p-textarea {
    border-color: hsl(var(--destructive)) !important;
    background-color: transparent !important;
}

/* Focus state for textarea */
.p-textarea.invalid-textarea:focus,
.invalid-textarea.p-textarea:focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Dark mode error state for textarea */
.dark .p-textarea.invalid-textarea,
.dark .invalid-textarea.p-textarea {
    border-color: hsl(var(--destructive)) !important;
}
</style>
