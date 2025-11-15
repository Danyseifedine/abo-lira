<script setup lang="ts">
import DashboardDeleteDialog from '@/common/components/dashboards/datatable/datatableDeleteDialog.vue';
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import { useToast } from '@/core/composables/useToast';
import { useFormatDate } from '@/core/utils/formatters-locale';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@ui/avatar';
import { Badge } from '@ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Separator } from '@ui/separator';
import { Edit, Image as ImageIcon, Package, Tag, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { DiscountProduct } from './datatable/type';

const props = defineProps<{
    product: DiscountProduct;
}>();

const { initFlashToasts } = useToast();
initFlashToasts();

// Use formatters - dates always in English
const formatDate = useFormatDate();

// Format currency
const formatCurrency = (amount: string | number) => {
    const numAmount = Number(amount);
    const formatted = numAmount.toFixed(2);
    return `$${formatted}`;
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: __('datatable.discounts.title'), href: route('super-admin.discounts.index') },
    { title: props.product.name, href: route('super-admin.discounts.show', props.product.id) },
];

// Dialogs
const deleteDialogOpen = ref(false);

const openDeleteDialog = () => {
    deleteDialogOpen.value = true;
};

// Get product image
const productImage = computed(() => props.product.image || '/images/default-product.png');
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head :title="__('datatable.discounts.title') + ' - ' + product.name" />

        <div class="space-y-6 p-4">
            <!-- Header with Product Name and Actions -->
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="flex items-center gap-3 text-3xl font-bold">
                        <Package class="h-8 w-8" />
                        {{ product.name }}
                    </h1>
                    <p class="mt-1 text-muted-foreground">{{ __('datatable.sku') }}: {{ product.sku }}</p>
                </div>

                <div class="flex gap-2">
                    <DashboardButton variant="outline" @click="router.visit(route('super-admin.discounts.edit', product.id))">
                        <Edit class="mr-2 h-4 w-4" />
                        {{ __('datatable.edit') }}
                    </DashboardButton>
                    <DashboardButton variant="destructive" @click="openDeleteDialog">
                        <Trash2 class="mr-2 h-4 w-4" />
                        {{ __('datatable.delete') }}
                    </DashboardButton>
                </div>
            </div>

            <Separator />

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Left Column - Product Image and Variants -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Product Image (only if available) -->
                    <Card v-if="product.image">
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <ImageIcon class="h-5 w-5" />
                                {{ __('datatable.product_image') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="flex items-center justify-center">
                                <img
                                    :src="productImage"
                                    :alt="product.name"
                                    class="h-96 w-full max-w-2xl rounded-lg border-2 border-border object-cover shadow-lg"
                                    @error="
                                        (e) => {
                                            (e.target as HTMLImageElement).src = '/images/default-product.png';
                                        }
                                    "
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Product Variants -->
                    <Card v-if="product.variants && product.variants.length > 0">
                        <CardHeader>
                            <CardTitle>{{ __('datatable.product_variants') }}</CardTitle>
                            <CardDescription>{{ product.variants.length }} {{ __('datatable.variants') }}</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div
                                    v-for="variant in product.variants"
                                    :key="variant.id"
                                    class="flex items-start gap-4 rounded-lg border p-4 transition-colors hover:bg-accent/50"
                                >
                                    <!-- Variant Image -->
                                    <Avatar class="h-20 w-20 rounded-md">
                                        <AvatarImage v-if="variant.image" :src="variant.image" :alt="product.name" class="object-cover" />
                                        <AvatarFallback class="rounded-md bg-muted">
                                            <Package class="h-8 w-8 text-muted-foreground" />
                                        </AvatarFallback>
                                    </Avatar>

                                    <!-- Variant Details -->
                                    <div class="min-w-0 flex-1">
                                        <p class="font-mono text-sm text-muted-foreground">{{ __('datatable.sku') }}: {{ variant.sku }}</p>
                                        <p class="mt-1 font-semibold">{{ formatCurrency(variant.price) }}</p>

                                        <!-- Variant Info -->
                                        <div class="mt-2 flex items-center gap-3">
                                            <div v-if="variant.color" class="flex items-center gap-2">
                                                <span class="text-sm text-muted-foreground">{{ __('datatable.color') }}:</span>
                                                <div class="flex items-center gap-1">
                                                    <div class="h-4 w-4 rounded-full border" :style="{ backgroundColor: variant.color.hex }"></div>
                                                    <span class="text-sm">{{ variant.color.name_en }}</span>
                                                </div>
                                            </div>
                                            <div v-if="variant.size" class="flex items-center gap-2">
                                                <span class="text-sm text-muted-foreground">{{ __('datatable.size') }}:</span>
                                                <Badge variant="outline">{{ variant.size.name_en }}</Badge>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column - Discount Info and Product Details -->
                <div class="space-y-6">
                    <!-- Discount Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <Tag class="h-5 w-5" />
                                {{ __('datatable.discount_information') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">{{ __('datatable.discount_price') }}</span>
                                <span class="text-xl font-bold text-green-600">{{ formatCurrency(product.discount_price) }}</span>
                            </div>

                            <Separator />

                            <div class="flex items-center justify-between">
                                <span class="text-muted-foreground">{{ __('datatable.has_limited_time_discount') }}</span>
                                <Badge :variant="product.has_limited_time_discount ? 'success' : 'secondary'">
                                    {{ product.has_limited_time_discount ? __('datatable.yes') : __('datatable.no') }}
                                </Badge>
                            </div>

                            <div v-if="product.has_limited_time_discount" class="space-y-3">
                                <Separator />
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-foreground">{{ __('datatable.discount_start_date') }}</span>
                                    <span class="text-sm">{{ product.discount_start_date ? formatDate(product.discount_start_date) : 'N/A' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-muted-foreground">{{ __('datatable.discount_end_date') }}</span>
                                    <span class="text-sm">{{ product.discount_end_date ? formatDate(product.discount_end_date) : 'N/A' }}</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Product Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2">
                                <Package class="h-5 w-5" />
                                {{ __('datatable.product_information') }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.category') }}</span>
                                <Badge v-if="product.category" variant="outline">
                                    {{ product.category.name_en }}
                                </Badge>
                                <span v-else class="text-sm">N/A</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.quality') }}</span>
                                <Badge v-if="product.quality" variant="outline">
                                    {{ product.quality.name_en }}
                                </Badge>
                                <span v-else class="text-sm">N/A</span>
                            </div>

                            <Separator />

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">{{ __('datatable.created_at') }}</span>
                                <span class="text-sm">{{ formatDate(product.created_at) }}</span>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <!-- Delete Dialog -->
        <DashboardDeleteDialog
            v-model:open="deleteDialogOpen"
            :item-id="product.id"
            :item-name="product.name"
            route-name="super-admin.discounts.destroy"
            :title="__('datatable.delete_confirmation')"
        />
    </AdminLayout>
</template>
