<script setup lang="ts">
import type { Component } from 'vue';
import Tag from 'primevue/tag';

const props = defineProps<{
    value: string;
    severity?: 'info' | 'success' | 'warning' | 'danger';
    icon?: Component;
    }>();
</script>

<template>
    <Tag :value="props.value" :severity="props.severity" :icon="props.icon" />
</template>
