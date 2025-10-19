<script setup lang="ts">
import { cn } from '@core/utils/utils';
import { Label, type LabelProps } from 'radix-vue';
import { computed, type HTMLAttributes } from 'vue';

const props = defineProps<LabelProps & { class?: HTMLAttributes['class']; required?: boolean }>();

const delegatedProps = computed(() => {
    const { class: _, required: __, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <Label
        v-bind="delegatedProps"
        :class="cn('text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70', props.class)"
    >
        <slot />
        <span v-if="required" class="ml-1 text-destructive">*</span>
    </Label>
</template>
