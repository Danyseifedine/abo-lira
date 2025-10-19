<script setup lang="ts">
interface Props {
    /**
     * Hint text
     */
    text?: string | null | undefined;
}

defineProps<Props>();
</script>
<template>
    <p class="text-muted-foreground text-xs">
        {{ text }}
    </p>
</template>

<style scoped></style>
