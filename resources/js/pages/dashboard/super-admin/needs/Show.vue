<script setup lang="ts">
import DashboardDeleteDialog from '@/common/components/dashboards/datatable/datatableDeleteDialog.vue';
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import { useToast } from '@/core/composables/useToast';
import { useFormatDate } from '@/core/utils/formatters-locale';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Badge } from '@ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Separator } from '@ui/separator';
import { Calendar, CheckCircle, Clock, MessageSquare, Phone, Trash2, User, XCircle } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Need } from './datatable/type';

const props = defineProps<{
    need: Need;
}>();

const { initFlashToasts } = useToast();
initFlashToasts();

// Use formatters - dates always in English
const formatDate = useFormatDate();

// Get full customer name
const customerName = computed(() => `${props.need.f_name} ${props.need.l_name}`);

// Get status icon and color
const getStatusConfig = (status: string) => {
    type BadgeVariant = 'default' | 'destructive' | 'outline' | 'secondary' | 'success' | 'warning' | 'info' | 'muted' | 'dark' | 'light' | 'pink';
    
    const configs: Record<string, { icon: any; variant: BadgeVariant; color: string }> = {
        unread: { icon: Clock, variant: 'warning', color: 'text-yellow-500' },
        read: { icon: CheckCircle, variant: 'success', color: 'text-green-500' },
    };
    return configs[status] || configs.unread;
};

// Get image URL
const imageUrl = computed(() => props.need.image || '/images/default-avatar.png');

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: __('datatable.needs.title'), href: route('super-admin.needs.index') },
    { title: customerName.value, href: route('super-admin.needs.show', props.need.id) },
];

// Dialogs
const deleteDialogOpen = ref(false);
const markAsReadDialogOpen = ref(false);

const openDeleteDialog = () => {
    deleteDialogOpen.value = true;
};

const markAsRead = () => {
    router.patch(route('super-admin.needs.mark-as-read', props.need.id), {}, {
        onSuccess: () => {
            markAsReadDialogOpen.value = false;
        },
    });
};

// Status options
const statusOptions = [
    { value: 'unread', label: __('datatable.unread') },
    { value: 'read', label: __('datatable.read') },
];
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head :title="__('datatable.needs.title') + ' - ' + customerName" />

        <div class="space-y-6 p-4">
            <!-- Header with Customer Name and Actions -->
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="flex items-center gap-3 text-3xl font-bold">
                        <User class="h-8 w-8" />
                        {{ customerName }}
                    </h1>
                    <p class="mt-1 text-muted-foreground">{{ formatDate(need.created_at) }}</p>
                </div>

                <div class="flex gap-2">
                    <DashboardButton v-if="need.status === 'unread'" variant="default" @click="markAsRead">
                        <CheckCircle class="mr-2 h-4 w-4" />
                        {{ __('datatable.mark_as_read') }}
                    </DashboardButton>
                    <DashboardButton variant="destructive" @click="openDeleteDialog">
                        <Trash2 class="mr-2 h-4 w-4" />
                        {{ __('datatable.delete') }}
                    </DashboardButton>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="flex items-center gap-2">
                <component :is="getStatusConfig(need.status).icon" :class="['h-5 w-5', getStatusConfig(need.status).color]" />
                <Badge :variant="getStatusConfig(need.status).variant" class="px-4 py-1 text-base">
                    {{ need.status === 'unread' ? __('datatable.unread') : __('datatable.read') }}
                </Badge>
            </div>

            <Separator />

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Left Column - Image and Message -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Image -->
                    <Card>
                        <CardHeader>
                            <CardTitle>{{ __('datatable.image') }}</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="flex items-center justify-center">
                                <img
                                    :src="imageUrl"
                                    :alt="customerName"
                                    class="h-96 w-full max-w-2xl object-cover rounded-lg border-2 border-border shadow-lg"
                                    @error="(e) => { (e.target as HTMLImageElement).src = '/images/default-avatar.png' }"
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Message -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <MessageSquare class="h-5 w-5" />
                                {{ __('datatable.message') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p class="whitespace-pre-wrap text-base leading-relaxed">{{ need.message }}</p>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column - Customer Info -->
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <User class="h-5 w-5" />
                                {{ __('datatable.customer_information') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <!-- Customer Name -->
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-muted-foreground">{{ __('datatable.f_name') }}</p>
                                <p class="text-base font-semibold">{{ need.f_name }}</p>
                            </div>

                            <Separator />

                            <div class="space-y-2">
                                <p class="text-sm font-medium text-muted-foreground">{{ __('datatable.l_name') }}</p>
                                <p class="text-base font-semibold">{{ need.l_name }}</p>
                            </div>

                            <Separator />

                            <!-- Phone Number -->
                            <div class="flex items-start gap-3">
                                <Phone class="mt-0.5 h-5 w-5 text-muted-foreground" />
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-muted-foreground">{{ __('datatable.phone') }}</p>
                                    <p class="text-sm font-mono">{{ need.phone_number }}</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Need Details -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <Calendar class="h-5 w-5" />
                                {{ __('datatable.need_details') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.status') }}</span>
                                <Badge :variant="getStatusConfig(need.status).variant">
                                    {{ need.status === 'unread' ? __('datatable.unread') : __('datatable.read') }}
                                </Badge>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.created_at') }}</span>
                                <span class="text-sm">{{ formatDate(need.created_at) }}</span>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <!-- Delete Dialog -->
        <DashboardDeleteDialog
            v-model:open="deleteDialogOpen"
            :item-id="need.id"
            :item-name="customerName"
            route-name="super-admin.needs.destroy"
            :title="__('datatable.delete_confirmation')"
        />
    </AdminLayout>
</template>

