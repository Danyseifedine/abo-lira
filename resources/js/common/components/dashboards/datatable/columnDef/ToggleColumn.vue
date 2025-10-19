<script setup lang="ts">
import { Switch } from '@ui/switch';
import { computed, ref } from 'vue';

interface ToggleControl {
    element: HTMLElement;
    dontToggle: () => void;
    revert: () => void;
    toggle: () => void;
}

interface Props {
    value: any;
    row: any;
    onToggle?: (value: boolean, row: any, control: ToggleControl) => void;
    disabled?: (row: any) => boolean;
    toggledWhen?: (value: any, row: any) => boolean;
    size?: 'sm' | 'default' | 'lg';
}

const props = withDefaults(defineProps<Props>(), {
    size: 'default',
});

const switchRef = ref<HTMLElement>();
const localToggleState = ref<boolean | null>(null);

const isDisabled = computed(() => {
    return props.disabled ? props.disabled(props.row) : false;
});

const isToggled = computed({
    get: () => {
        if (localToggleState.value !== null) {
            return localToggleState.value;
        }
        return props.toggledWhen ? props.toggledWhen(props.value, props.row) : !!props.value;
    },
    set: (newValue: boolean) => {
        if (isDisabled.value || !props.onToggle || !switchRef.value) return;

        localToggleState.value = newValue;

        const control: ToggleControl = {
            element: switchRef.value,
            dontToggle: () => (localToggleState.value = null),
            revert: () => (localToggleState.value = null),
            toggle: () => {
                const currentPropValue = props.toggledWhen ? props.toggledWhen(props.value, props.row) : !!props.value;
                localToggleState.value = !currentPropValue;
            },
        };

        props.onToggle(newValue, props.row, control);
    },
});

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'scale-75';
        case 'lg':
            return 'scale-125';
        default:
            return '';
    }
});
</script>

<template>
    <div class="flex items-center justify-center" @click.stop.prevent>
        <Switch
            ref="switchRef"
            v-model="isToggled"
            :disabled="isDisabled"
            :class="[sizeClasses, isDisabled ? 'cursor-not-allowed opacity-50' : '']"
        />
    </div>
</template>
