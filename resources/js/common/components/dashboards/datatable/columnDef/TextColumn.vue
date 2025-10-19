<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    value: any;
    format?: (value: any) => string;
}

const props = defineProps<Props>();

const formatted = computed(() => {
    if (props.format) {
        return props.format(props.value);
    }
    return props.value ?? '-';
});
</script>

<template>
    <span>{{ formatted }}</span>
</template>
