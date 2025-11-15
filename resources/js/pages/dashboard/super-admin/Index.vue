<script setup lang="ts">
import { useFormatCurrency } from '@/core/utils/formatters-locale';
import { __ } from '@/core/utils/translations';
import { type BreadcrumbItem } from '@core/types';
import { Head, usePage } from '@inertiajs/vue3';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@ui/card';
import {
    BadgeCheck,
    Bell,
    Calendar,
    CheckCircle,
    Clock,
    DollarSign,
    FolderTree,
    Maximize2,
    Package,
    PackageCheck,
    Palette,
    Percent,
    RefreshCw,
    ShoppingCart,
    Tag,
    TrendingUp,
    Truck,
    Users,
    XCircle,
} from 'lucide-vue-next';
import { computed } from 'vue';

interface Stats {
    // Orders
    orders_count: number;
    orders_today: number;
    orders_this_month: number;
    orders_pending: number;
    orders_accepted: number;
    orders_on_the_way: number;
    orders_completed: number;
    orders_rejected: number;
    orders_refunded: number;

    // Sales
    total_sales: number;
    sales_today: number;
    sales_this_month: number;
    average_order_value: number;

    // Products
    products_count: number;
    products_active: number;
    products_inactive: number;
    products_with_variants: number;
    products_with_discounts: number;
    products_active_discounts: number;
    products_scheduled_discounts: number;

    // Categories
    categories_count: number;
    categories_active: number;

    // Sizes
    sizes_count: number;
    sizes_active: number;

    // Qualities
    qualities_count: number;
    qualities_active: number;

    // Colors
    colors_count: number;
    colors_active: number;

    // Variants
    variants_count: number;
    variants_active: number;
    variants_inactive: number;

    // Needs
    needs_unread_count: number;
    needs_read_count: number;

    // Users
    users_count: number;
    users_active: number;

    // Most Bought Product
    most_bought_product: {
        id: number;
        name_en: string;
        name_ar: string;
        bought_count: number;
        sku: string;
    } | null;
}

const props = defineProps<{
    stats: Stats;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: __('sidebar.dashboard'),
        href: route('super-admin.dashboard'),
    },
];

const formatCurrency = useFormatCurrency();
const page = usePage();

const mostBoughtProductName = computed(() => {
    if (!props.stats.most_bought_product) {
        return __('datatable.no_data');
    }
    return page.props.locale === 'ar' ? props.stats.most_bought_product.name_ar : props.stats.most_bought_product.name_en;
});
</script>

<template>
    <Head :title="__('sidebar.dashboard')" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-4">
            <div>
                <h1 class="text-3xl font-bold">{{ __('sidebar.dashboard') }}</h1>
                <p class="mt-1 text-sm text-muted-foreground">{{ __('datatable.dashboard_description') }}</p>
            </div>

            <!-- Statistics Cards Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <!-- Orders Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders') }}</CardTitle>
                        <ShoppingCart class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.orders_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_orders') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_today') }}</CardTitle>
                        <Calendar class="h-4 w-4 text-blue-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-blue-600">{{ stats.orders_today }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.orders_today_desc') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_this_month') }}</CardTitle>
                        <Calendar class="h-4 w-4 text-purple-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-purple-600">{{ stats.orders_this_month }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.orders_this_month_desc') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_pending') }}</CardTitle>
                        <Clock class="h-4 w-4 text-yellow-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-yellow-600">{{ stats.orders_pending }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.pending_orders') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_accepted') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-blue-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-blue-600">{{ stats.orders_accepted }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.accepted_orders') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_on_the_way') }}</CardTitle>
                        <Truck class="h-4 w-4 text-orange-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-orange-600">{{ stats.orders_on_the_way }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.on_the_way_orders') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_completed') }}</CardTitle>
                        <PackageCheck class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.orders_completed }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.completed_orders') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_rejected') }}</CardTitle>
                        <XCircle class="h-4 w-4 text-red-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-red-600">{{ stats.orders_rejected }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.rejected_orders') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.orders_refunded') }}</CardTitle>
                        <RefreshCw class="h-4 w-4 text-gray-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-gray-600">{{ stats.orders_refunded }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.refunded_orders') }}</p>
                    </CardContent>
                </Card>

                <!-- Sales Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.total_sales') }}</CardTitle>
                        <DollarSign class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ formatCurrency(stats.total_sales) }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_revenue') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.sales_today') }}</CardTitle>
                        <TrendingUp class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ formatCurrency(stats.sales_today) }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.sales_today_desc') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.sales_this_month') }}</CardTitle>
                        <TrendingUp class="h-4 w-4 text-blue-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-blue-600">{{ formatCurrency(stats.sales_this_month) }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.sales_this_month_desc') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.average_order_value') }}</CardTitle>
                        <DollarSign class="h-4 w-4 text-purple-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-purple-600">{{ formatCurrency(stats.average_order_value) }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.avg_order_value_desc') }}</p>
                    </CardContent>
                </Card>

                <!-- Products Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.products') }}</CardTitle>
                        <Package class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.products_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_products') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.products_active') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.products_active }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_products') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.products_inactive') }}</CardTitle>
                        <XCircle class="h-4 w-4 text-red-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-red-600">{{ stats.products_inactive }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.inactive_products') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.products_with_variants') }}</CardTitle>
                        <Package class="h-4 w-4 text-blue-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-blue-600">{{ stats.products_with_variants }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.products_with_variants_desc') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.products_with_discounts') }}</CardTitle>
                        <Percent class="h-4 w-4 text-orange-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-orange-600">{{ stats.products_with_discounts }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.products_with_discounts_desc') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.products_active_discounts') }}</CardTitle>
                        <Tag class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.products_active_discounts }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_discounts') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.products_scheduled_discounts') }}</CardTitle>
                        <Calendar class="h-4 w-4 text-purple-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-purple-600">{{ stats.products_scheduled_discounts }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.scheduled_discounts') }}</p>
                    </CardContent>
                </Card>

                <!-- Categories Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.categories') }}</CardTitle>
                        <FolderTree class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.categories_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_categories') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.categories_active') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.categories_active }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_categories') }}</p>
                    </CardContent>
                </Card>

                <!-- Sizes Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.sizes') }}</CardTitle>
                        <Maximize2 class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.sizes_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_sizes') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.sizes_active') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.sizes_active }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_sizes') }}</p>
                    </CardContent>
                </Card>

                <!-- Qualities Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.qualities') }}</CardTitle>
                        <BadgeCheck class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.qualities_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_qualities') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.qualities_active') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.qualities_active }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_qualities') }}</p>
                    </CardContent>
                </Card>

                <!-- Colors Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.colors') }}</CardTitle>
                        <Palette class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.colors_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_colors') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.colors_active') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.colors_active }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_colors') }}</p>
                    </CardContent>
                </Card>

                <!-- Variants Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.variants') }}</CardTitle>
                        <Package class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.variants_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_variants') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.variants_active') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.variants_active }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_variants') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.variants_inactive') }}</CardTitle>
                        <XCircle class="h-4 w-4 text-red-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-red-600">{{ stats.variants_inactive }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.inactive_variants') }}</p>
                    </CardContent>
                </Card>

                <!-- Needs Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.needs_unread') }}</CardTitle>
                        <Bell class="h-4 w-4 text-yellow-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-yellow-600">{{ stats.needs_unread_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.unread_needs') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.needs_read') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.needs_read_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.read_needs') }}</p>
                    </CardContent>
                </Card>

                <!-- Users Section -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.users') }}</CardTitle>
                        <Users class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.users_count }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.total_users') }}</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.users_active') }}</CardTitle>
                        <CheckCircle class="h-4 w-4 text-green-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600">{{ stats.users_active }}</div>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.active_users') }}</p>
                    </CardContent>
                </Card>

                <!-- Most Bought Product -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ __('datatable.most_bought_product') }}</CardTitle>
                        <TrendingUp class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-lg font-bold">{{ mostBoughtProductName }}</div>
                        <p class="text-xs text-muted-foreground">
                            {{ __('datatable.bought_count') }}: {{ stats.most_bought_product?.bought_count || 0 }}
                        </p>
                        <p v-if="stats.most_bought_product" class="mt-1 text-xs text-muted-foreground">SKU: {{ stats.most_bought_product.sku }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
