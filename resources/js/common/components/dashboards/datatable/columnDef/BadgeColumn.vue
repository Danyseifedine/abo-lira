<script setup lang="ts">
import { Badge } from '@ui/badge';
import { computed } from 'vue';

interface Props {
    value: any;
    variants?: Record<string, string>;
    defaultVariant?: string;
}

const props = withDefaults(defineProps<Props>(), {
    defaultVariant: 'secondary',
});

const getVariant = (val: string) => {
    return props.variants?.[val] || props.defaultVariant;
};

const items = computed(() => {
    if (Array.isArray(props.value)) {
        return props.value;
    }
    return props.value ? [props.value] : [];
});
</script>

<template>
    <div v-if="items.length > 0" class="flex flex-wrap gap-1">
        <Badge v-for="(item, index) in items" :key="index" :variant="getVariant(typeof item === 'object' ? item.name : item) as any" class="text-xs">
            {{ typeof item === 'object' ? item.name : item }}
        </Badge>
    </div>
    <span v-else class="text-sm text-muted-foreground">-</span>
</template>
