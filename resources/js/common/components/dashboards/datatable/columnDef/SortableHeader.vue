<script setup lang="ts">
import { Button } from '@ui/button';
import { ArrowDown, ArrowUp, ArrowUpDown } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    column: any;
    label: string;
}

const props = defineProps<Props>();

const handleSort = () => {
    props.column.toggleSorting(props.column.getIsSorted() === 'asc');
};

const sortIcon = computed(() => {
    const sorted = props.column.getIsSorted();
    if (sorted === 'asc') return ArrowUp;
    if (sorted === 'desc') return ArrowDown;
    return ArrowUpDown;
});
</script>

<template>
    <Button variant="ghost" size="sm" class="-ml-3 h-8 data-[state=open]:bg-accent" @click="handleSort">
        <span>{{ label }}</span>
        <component :is="sortIcon" class="ml-2 h-4 w-4" />
    </Button>
</template>
