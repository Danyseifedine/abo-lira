<script setup lang="ts">
import DatePicker from 'primevue/datepicker';
import { computed } from 'vue';

interface Props {
    /**
     * Selected date value (v-model)
     */
    modelValue?: Date | Date[] | null;

    /**
     * Selection mode
     * @default 'single'
     * - single: Select single date
     * - multiple: Select multiple dates
     * - range: Select date range
     */
    selectionMode?: 'single' | 'multiple' | 'range';

    /**
     * View mode for the picker
     * @default 'date'
     * - date: Show calendar with days
     * - month: Show only months
     * - year: Show only years
     */
    view?: 'date' | 'month' | 'year';

    /**
     * Date format pattern
     * @default 'yy-mm-dd'
     * Examples: 'dd/mm/yy', 'mm/dd/yy', 'yy-mm-dd'
     */
    dateFormat?: string;

    /**
     * Show time picker
     * @default false
     */
    showTime?: boolean;

    /**
     * Show time picker only (no date selection)
     * @default false
     */
    timeOnly?: boolean;

    /**
     * Hour format (12 or 24 hour)
     * @default '24'
     */
    hourFormat?: '12' | '24';

    /**
     * Show seconds in time picker
     * @default false
     */
    showSeconds?: boolean;

    /**
     * Show calendar icon inside input
     * @default true
     */
    showIcon?: boolean;

    /**
     * Icon display position
     * @default 'button'
     * - button: Show icon as button on right
     * - input: Show icon inside input on left
     */
    iconDisplay?: 'button' | 'input';

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
     * Show clear button
     * @default true
     */
    showClear?: boolean;

    /**
     * Minimum selectable date
     */
    minDate?: Date;

    /**
     * Maximum selectable date
     */
    maxDate?: Date;

    /**
     * Disabled dates array
     */
    disabledDates?: Date[];

    /**
     * Disabled days of week (0-6, Sunday-Saturday)
     */
    disabledDays?: number[];

    /**
     * Show week numbers
     * @default false
     */
    showWeek?: boolean;

    /**
     * Number of months to display
     * @default 1
     */
    numberOfMonths?: number;

    /**
     * Inline display mode (no input, just calendar)
     * @default false
     */
    inline?: boolean;

    /**
     * Additional class names
     */
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    selectionMode: 'single',
    view: 'date',
    dateFormat: 'yy-mm-dd',
    showTime: false,
    timeOnly: false,
    hourFormat: '24',
    showSeconds: false,
    showIcon: true,
    iconDisplay: 'button',
    placeholder: 'Select date',
    error: null,
    disabled: false,
    required: false,
    id: undefined,
    size: 'small',
    fluid: true,
    showClear: true,
    minDate: undefined,
    maxDate: undefined,
    disabledDates: undefined,
    disabledDays: undefined,
    showWeek: false,
    numberOfMonths: 1,
    inline: false,
    class: '',
});

const emit = defineEmits<{
    'update:modelValue': [value: Date | Date[] | null];
    change: [event: any];
    blur: [event: any];
    focus: [event: any];
    select: [value: Date | Date[]];
    'month-change': [event: any];
    'year-change': [event: any];
}>();

// Computed class with error state
const wrapperClass = computed(() => {
    const classes = ['datepicker-wrapper'];

    if (props.class) {
        classes.push(props.class);
    }

    if (props.error) {
        classes.push('has-error');
    }

    return classes.join(' ');
});

// Handle change event
const handleChange = (value: any) => {
    emit('update:modelValue', value);
    emit('change', value);
};

// Handle select event
const handleSelect = (value: Date | Date[]) => {
    emit('select', value);
};

// Handle blur event
const handleBlur = (event: any) => {
    emit('blur', event);
};

// Handle focus event
const handleFocus = (event: any) => {
    emit('focus', event);
};

// Handle month change
const handleMonthChange = (event: any) => {
    emit('month-change', event);
};

// Handle year change
const handleYearChange = (event: any) => {
    emit('year-change', event);
};
</script>

<template>
    <div :class="wrapperClass">
        <DatePicker
            :id="id"
            :model-value="modelValue"
            :selection-mode="selectionMode"
            :view="view"
            :date-format="dateFormat"
            :show-time="showTime"
            :time-only="timeOnly"
            :hour-format="hourFormat"
            :show-seconds="showSeconds"
            :show-icon="showIcon"
            :icon-display="iconDisplay"
            :placeholder="placeholder"
            :disabled="disabled"
            :required="required"
            :size="size"
            :fluid="fluid"
            :show-clear="showClear"
            :min-date="minDate"
            :max-date="maxDate"
            :disabled-dates="disabledDates"
            :disabled-days="disabledDays"
            :show-week="showWeek"
            :number-of-months="numberOfMonths"
            :inline="inline"
            @update:model-value="handleChange"
            @date-select="handleSelect"
            @blur="handleBlur"
            @focus="handleFocus"
            @month-change="handleMonthChange"
            @year-change="handleYearChange"
        />
    </div>
</template>

<style>
/* Global styles for this component's password inputs */
.datepicker-wrapper .p-datepicker input {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

/* Dark mode overrides */
.dark .datepicker-wrapper .p-datepicker input {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}

/* Error state for input */
.datepicker-wrapper.has-error .p-datepicker input {
    border-color: hsl(var(--destructive)) !important;
}

/* Focus state for error inputs */
.datepicker-wrapper.has-error .p-datepicker input:focus {
    border-color: hsl(var(--destructive)) !important;
    box-shadow: 0 0 0 2px hsl(var(--destructive) / 0.2) !important;
}

/* Toggle mask button styles if needed */
.datepicker-wrapper .p-datepicker .p-datepicker-toggle-mask {
    border: 1px solid #e4e4e4 !important;
    background-color: transparent !important;
}

.dark .datepicker-wrapper .p-datepicker .p-datepicker-toggle-mask {
    border: 1px solid #262626 !important;
    background-color: transparent !important;
}
</style>
