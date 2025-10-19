<script setup lang="ts">
import Separator from '@ui/separator/Separator.vue';
import { cn } from '@core/utils/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <Separator data-sidebar="separator" :class="cn('mx-2 w-auto bg-sidebar-border', props.class)">
        <slot />
    </Separator>
</template>
