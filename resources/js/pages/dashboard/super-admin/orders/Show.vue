<script setup lang="ts">
import DashboardDeleteDialog from '@/common/components/dashboards/datatable/datatableDeleteDialog.vue';
import DashboardStatusChangeDialog from '@/common/components/dashboards/datatable/datatableStatusChangeDialog.vue';
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import { useToast } from '@/core/composables/useToast';
import { useFormatCurrency, useFormatDate } from '@/core/utils/formatters-locale';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@ui/avatar';
import { Badge } from '@ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Separator } from '@ui/separator';
import {
    Calendar,
    CheckCircle,
    Clock,
    DollarSign,
    Edit,
    History,
    MapPin,
    Package,
    Phone,
    RefreshCcw,
    Trash2,
    Truck,
    User,
    XCircle,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Order } from './datatable/type';

const props = defineProps<{
    order: Order;
    statusOptions: Array<{ value: string; label: string }>;
}>();

const { initFlashToasts } = useToast();
initFlashToasts();

// Use formatters - dates always in English, currency simple format
const formatDate = useFormatDate();
const formatCurrency = useFormatCurrency();

// Calculate subtotal
const subtotal = computed(() => {
    if (!props.order.items || props.order.items.length === 0) {
        return 0;
    }
    return props.order.items.reduce((sum, item) => {
        return sum + Number(item.price) * item.quantity;
    }, 0);
});

// Get status icon and color
const getStatusConfig = (status: string) => {
    type BadgeVariant = 'default' | 'destructive' | 'outline' | 'secondary' | 'success' | 'warning' | 'info' | 'muted' | 'dark' | 'light' | 'pink';

    const configs: Record<string, { icon: any; variant: BadgeVariant; color: string }> = {
        pending: { icon: Clock, variant: 'secondary', color: 'text-yellow-500' },
        accepted: { icon: CheckCircle, variant: 'success', color: 'text-green-500' },
        on_the_way: { icon: Truck, variant: 'info', color: 'text-blue-500' },
        completed: { icon: CheckCircle, variant: 'success', color: 'text-green-600' },
        rejected: { icon: XCircle, variant: 'destructive', color: 'text-red-500' },
        refunded: { icon: RefreshCcw, variant: 'warning', color: 'text-orange-500' },
    };
    return configs[status] || configs.pending;
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: __('datatable.orders.title'), href: route('super-admin.orders.index') },
    { title: props.order.order_number, href: route('super-admin.orders.show', props.order.id) },
];

// Dialogs
const statusChangeDialogOpen = ref(false);
const deleteDialogOpen = ref(false);

const openStatusChangeDialog = () => {
    statusChangeDialogOpen.value = true;
};

const openDeleteDialog = () => {
    deleteDialogOpen.value = true;
};

// Get full customer name
const customerName = computed(() => `${props.order.f_name} ${props.order.l_name}`);

// Get initials for avatar
const getInitials = (name: string) => {
    return name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
};

// Get product image with fallback
const getProductImage = (item: any) => {
    if (item.variant?.image) {
        return item.variant.image;
    }
    if (item.product?.image) {
        return item.product.image;
    }
    return '';
};
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head :title="__('datatable.orders.title') + ' - ' + order.order_number" />

        <div class="space-y-6 p-4">
            <!-- Header with Order Number and Actions -->
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="flex items-center gap-3 text-3xl font-bold">
                        <Package class="h-8 w-8" />
                        {{ order.order_number }}
                    </h1>
                    <p class="mt-1 text-muted-foreground">{{ formatDate(order.created_at) }}</p>
                </div>

                <div class="flex gap-2">
                    <DashboardButton variant="outline" @click="openStatusChangeDialog">
                        <Edit class="mr-2 h-4 w-4" />
                        {{ __('datatable.change_status') }}
                    </DashboardButton>
                    <DashboardButton variant="destructive" @click="openDeleteDialog">
                        <Trash2 class="mr-2 h-4 w-4" />
                        {{ __('datatable.delete') }}
                    </DashboardButton>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="flex items-center gap-2">
                <component :is="getStatusConfig(order.status_raw).icon" :class="['h-5 w-5', getStatusConfig(order.status_raw).color]" />
                <Badge :variant="getStatusConfig(order.status_raw).variant" class="px-4 py-1 text-base">
                    {{ order.status }}
                </Badge>
            </div>

            <Separator />

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Left Column - Order Items -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Order Items -->
                    <Card>
                        <CardHeader>
                            <CardTitle>{{ __('datatable.order_items') }}</CardTitle>
                            <CardDescription>{{ order.items?.length || 0 }} {{ __('datatable.items') }}</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div
                                    v-for="item in order.items"
                                    :key="item.id"
                                    class="flex items-start gap-4 rounded-lg border p-4 transition-colors hover:bg-accent/50"
                                >
                                    <!-- Product Image -->
                                    <Avatar class="h-20 w-20 rounded-md">
                                        <AvatarImage :src="getProductImage(item)" :alt="item.product?.name || 'Product'" class="object-cover" />
                                        <AvatarFallback class="rounded-md bg-muted">
                                            <Package class="h-8 w-8 text-muted-foreground" />
                                        </AvatarFallback>
                                    </Avatar>

                                    <!-- Product Details -->
                                    <div class="min-w-0 flex-1">
                                        <h4 class="truncate text-base font-semibold">{{ item.product?.name || 'Unknown Product' }}</h4>
                                        <p class="mt-1 text-sm text-muted-foreground">{{ __('datatable.sku') }}: {{ item.product?.sku || 'N/A' }}</p>

                                        <!-- Variant Info -->
                                        <div v-if="item.variant" class="mt-2 flex items-center gap-3">
                                            <div v-if="item.variant.color" class="flex items-center gap-2">
                                                <span class="text-sm text-muted-foreground">{{ __('datatable.color') }}:</span>
                                                <div class="flex items-center gap-1">
                                                    <div
                                                        class="h-4 w-4 rounded-full border"
                                                        :style="{ backgroundColor: item.variant.color.hex }"
                                                    ></div>
                                                    <span class="text-sm">{{ item.variant.color.name_en }}</span>
                                                </div>
                                            </div>
                                            <div v-if="item.variant.size" class="flex items-center gap-2">
                                                <span class="text-sm text-muted-foreground">{{ __('datatable.size') }}:</span>
                                                <Badge variant="outline">{{ item.variant.size.name_en }}</Badge>
                                            </div>
                                        </div>

                                        <!-- Quantity and Price -->
                                        <div class="mt-2 flex items-center gap-4">
                                            <span class="text-sm text-muted-foreground">{{ __('datatable.quantity') }}: {{ item.quantity }}</span>
                                            <span class="text-sm text-muted-foreground"
                                                >{{ __('datatable.price') }}: {{ formatCurrency(item.price) }}</span
                                            >
                                        </div>
                                    </div>

                                    <!-- Total Price -->
                                    <div class="text-right">
                                        <p class="text-lg font-semibold">{{ formatCurrency(Number(item.price) * item.quantity) }}</p>
                                    </div>
                                </div>

                                <div v-if="!order.items || order.items.length === 0" class="py-8 text-center text-muted-foreground">
                                    {{ __('datatable.no_items') }}
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Order History -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <History class="h-5 w-5" />
                                {{ __('datatable.order_history') }}
                            </CardTitle>
                            <CardDescription>{{ __('datatable.status_changes_timeline') }}</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div v-if="order.histories && order.histories.length > 0" class="space-y-4">
                                <div v-for="(history, index) in order.histories" :key="history.id" class="flex items-start gap-4">
                                    <!-- Timeline Line -->
                                    <div class="flex flex-col items-center">
                                        <div
                                            :class="[
                                                'flex h-8 w-8 items-center justify-center rounded-full',
                                                getStatusConfig(history.status_raw).color.replace('text-', 'bg-'),
                                                'bg-opacity-20',
                                            ]"
                                        >
                                            <component
                                                :is="getStatusConfig(history.status_raw).icon"
                                                :class="['h-4 w-4', getStatusConfig(history.status_raw).color]"
                                            />
                                        </div>
                                        <div v-if="index < order.histories.length - 1" class="mt-2 h-12 w-0.5 bg-border"></div>
                                    </div>

                                    <!-- History Content -->
                                    <div class="flex-1 pb-4">
                                        <div class="flex items-center justify-between">
                                            <Badge :variant="getStatusConfig(history.status_raw).variant">
                                                {{ history.status }}
                                            </Badge>
                                            <span class="text-sm text-muted-foreground">{{ formatDate(history.created_at) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="py-8 text-center text-muted-foreground">
                                {{ __('datatable.no_history') }}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column - Order Summary and Customer Info -->
                <div class="space-y-6">
                    <!-- Order Summary -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <DollarSign class="h-5 w-5" />
                                {{ __('datatable.order_summary') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">{{ __('datatable.subtotal') }}</span>
                                <span class="font-medium">{{ formatCurrency(subtotal) }}</span>
                            </div>

                            <Separator />

                            <div class="flex items-center justify-between">
                                <span class="text-lg font-semibold">{{ __('datatable.total') }}</span>
                                <span class="text-xl font-bold">{{ formatCurrency(order.total_amount) }}</span>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Customer Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <User class="h-5 w-5" />
                                {{ __('datatable.customer_information') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <!-- Customer Avatar and Name -->
                            <div class="flex items-center gap-3">
                                <Avatar class="h-12 w-12">
                                    <AvatarFallback class="bg-primary/10 text-primary">{{ getInitials(customerName) }}</AvatarFallback>
                                </Avatar>
                                <div>
                                    <p class="font-semibold">{{ customerName }}</p>
                                </div>
                            </div>

                            <Separator />

                            <!-- Contact Details -->
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <Phone class="mt-0.5 h-5 w-5 text-muted-foreground" />
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-muted-foreground">{{ __('datatable.phone') }}</p>
                                        <p class="text-sm">{{ order.phone_number }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <MapPin class="mt-0.5 h-5 w-5 text-muted-foreground" />
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-muted-foreground">{{ __('datatable.address') }}</p>
                                        <p class="text-sm">{{ order.address }}</p>
                                        <p class="text-sm text-muted-foreground">{{ order.city }}</p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Order Details -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <Calendar class="h-5 w-5" />
                                {{ __('datatable.order_details') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.order_number') }}</span>
                                <span class="font-mono text-sm font-medium">{{ order.order_number }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.created_at') }}</span>
                                <span class="text-sm">{{ formatDate(order.created_at) }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.status') }}</span>
                                <Badge :variant="getStatusConfig(order.status_raw).variant">{{ order.status }}</Badge>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <!-- Status Change Dialog -->
        <DashboardStatusChangeDialog
            v-model:open="statusChangeDialogOpen"
            :item-id="order.id"
            :item-name="order.order_number"
            route-name="super-admin.orders.change-status"
            :status-options="statusOptions"
            :current-status="order.status_raw"
            :title="__('datatable.change_status')"
            :description="__('datatable.change_status_description')"
        />

        <!-- Delete Dialog -->
        <DashboardDeleteDialog
            v-model:open="deleteDialogOpen"
            :item-id="order.id"
            :item-name="order.order_number"
            route-name="super-admin.orders.destroy"
            :title="__('datatable.delete_confirmation')"
        />
    </AdminLayout>
</template>
