<script setup lang="ts">
import { useGlobalLayoutStore } from '@core/stores/layout';
import AppLogoIcon from '@shared/components/AppLogoIcon.vue';
import { computed } from 'vue';

const globalLayoutStore = useGlobalLayoutStore();

const containerClasses = computed(() => {
    const classes = ['flex', 'items-center'];

    // If title doesn't exist, apply logo positioning
    if (!globalLayoutStore.sidebarTitleExist) {
        if (globalLayoutStore.sidebarLogoPosition === 'center') {
            classes.push('justify-center', 'w-full');
        } else if (globalLayoutStore.sidebarLogoPosition === 'right') {
            classes.push('justify-end', 'w-full');
        } else {
            classes.push('justify-start');
        }
    }

    return classes.join(' ');
});

const logoImageStyle = computed(() => {
    return {
        width: globalLayoutStore.sidebarLogoSize,
        height: globalLayoutStore.sidebarLogoSize,
    };
});
</script>

<template>
    <div :class="containerClasses">
        <!-- Custom Logo Image -->
        <div v-if="globalLayoutStore.sidebarLogoExist && globalLayoutStore.sidebarLogoSrc">
            <img
                :src="globalLayoutStore.sidebarLogoSrc"
                :alt="globalLayoutStore.sidebarLogoAlt"
                :style="logoImageStyle"
                :class="globalLayoutStore.sidebarLogoClassName || 'object-contain'"
            />
        </div>
        <!-- Default Logo Icon -->
        <div v-else class="flex aspect-square size-8 items-center justify-center rounded-md">
            <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
        </div>

        <!-- Sidebar Title -->
        <div v-if="globalLayoutStore.sidebarTitleExist">
            <div class="ml-1 grid flex-1 text-left text-sm">
                <span class="mb-0.5 truncate font-semibold leading-none">{{ globalLayoutStore.sidebarTitle }}</span>
            </div>
        </div>
    </div>
</template>
