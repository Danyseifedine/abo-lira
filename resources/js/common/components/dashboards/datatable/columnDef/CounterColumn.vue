<script setup lang="ts">
interface Props {
    rowIndex: number
    startFrom?: number
}

const props = withDefaults(defineProps<Props>(), {
    startFrom: 1,
})

const counter = props.rowIndex + props.startFrom
</script>

<template>
    <div class="text-xs font-medium text-muted-foreground">
        {{ counter }}
    </div>
</template>
