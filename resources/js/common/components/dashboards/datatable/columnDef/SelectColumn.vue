<script setup lang="ts">
import { Checkbox } from '@ui/checkbox';

interface Props {
    table?: any;
    row?: any;
    mode: 'header' | 'cell';
}

const props = defineProps<Props>();

const handleHeaderChange = (checked: boolean) => {
    props.table?.toggleAllPageRowsSelected(!!checked);
};

const handleCellChange = (checked: boolean) => {
    props.row?.toggleSelected(!!checked);
};
</script>

<template>
    <div @click.stop.prevent>
        <Checkbox
            v-if="mode === 'header'"
            :checked="table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate')"
            @update:checked="handleHeaderChange"
            aria-label="Select all"
            class="translate-y-[2px]"
        />
        <Checkbox v-else :checked="row.getIsSelected()" @update:checked="handleCellChange" aria-label="Select row" class="translate-y-[2px]" />
    </div>
</template>
