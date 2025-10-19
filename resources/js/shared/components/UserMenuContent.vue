<script setup lang="ts">
import { useGlobalLayoutRouteStore } from '@core/stores/layout';
import type { User } from '@core/types';
import { Link } from '@inertiajs/vue3';
import UserInfo from '@shared/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@ui/dropdown-menu';
import { LogOut, User as UserIcon } from 'lucide-vue-next';

interface Props {
    user: User;
}

defineProps<Props>();

const globalLayoutRouteStore = useGlobalLayoutRouteStore();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :user="user" :show-email="true" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="globalLayoutRouteStore.settingsPath" as="button">
                <UserIcon class="mr-2 h-4 w-4" />
                Profile
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="route('logout')" as="button">
            <LogOut class="mr-2 h-4 w-4" />
            Log out
        </Link>
    </DropdownMenuItem>
</template>
