<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Button } from '@ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@ui/dropdown-menu';
import { MoreHorizontal } from 'lucide-vue-next';
import { computed } from 'vue';
import type { ActionItem } from '../index';
import { __ } from '@/core/utils/translations';

interface Props {
    row: any;
    actions: ActionItem[];
}

const props = defineProps<Props>();

const handleAction = (action: ActionItem, event: Event) => {
    // Stop propagation to prevent row click
    event.stopPropagation();

    if (action.onClick) {
        action.onClick(props.row);
    } else if (action.href) {
        const url = action.href(props.row);
        if (typeof window !== 'undefined' && router) {
            router.visit(url);
        }
    }
};

const visibleActions = computed(() => props.actions.filter((action) => !action.show || action.show(props.row)));
</script>

<template>
    <div @click.stop.prevent>
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button variant="ghost" size="icon" class="h-8 w-8">
                    <span class="sr-only">{{ __('datatable.open_menu') }}</span>
                    <MoreHorizontal class="h-4 w-4" />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" class="w-[160px]">
                <DropdownMenuLabel>{{ __('datatable.actions') }}</DropdownMenuLabel>
                <template v-for="(action, index) in visibleActions" :key="index">
                    <DropdownMenuSeparator v-if="action.separator" />
                    <DropdownMenuItem
                        v-else
                        :class="{
                            'text-destructive focus:text-destructive': action.destructive,
                        }"
                        @click="(e: Event) => handleAction(action, e)"
                    >
                        <component v-if="action.icon" :is="action.icon" class="mr-2 h-4 w-4" />
                        {{ action.label }}
                    </DropdownMenuItem>
                </template>
            </DropdownMenuContent>
        </DropdownMenu>
    </div>
</template>
