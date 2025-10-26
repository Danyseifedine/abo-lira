<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardFileUpload from '@/common/components/dashboards/form/DashboardFileUpload.vue';
import DashboardSelect from '@/common/components/dashboards/form/DashboardSelect.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import DashboardTextarea from '@/common/components/dashboards/form/DashboardTextarea.vue';
import DashboardToggle from '@/common/components/dashboards/form/DashboardToggle.vue';
import Hint from '@/common/components/dashboards/typography/Hint.vue';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import InputError from '@shared/components/InputError.vue';
import { Label } from '@ui/label';
import { computed, watch } from 'vue';
import type { Product } from '../datatable/type';

const page = usePage();

interface ProductCategory {
    id: number;
    name_en: string;
    name_ar: string;
}

interface ProductQuality {
    id: number;
    name_en: string;
    name_ar: string;
}

// Get option label based on locale
const optionLabel = computed(() => {
    return page.props.locale === 'ar' ? 'name_ar' : 'name_en';
});

const props = defineProps<{
    product: Product;
    categories: ProductCategory[];
    qualities: ProductQuality[];
    existingFiles?: any[];
    existingPlacementFiles?: any[];
}>();

const form = useForm({
    name_en: props.product.name_en,
    name_ar: props.product.name_ar,
    slug: props.product.slug,
    description_en: props.product.description_en || '',
    description_ar: props.product.description_ar || '',
    category_id: props.product.category_id,
    quality_id: props.product.quality_id,
    sku: props.product.sku || '',
    price: props.product.price,
    has_variants: props.product.has_variants || false,
    is_new: props.product.is_new || false,
    status: Boolean(props.product.status),
    temp_files: props.existingFiles || ([] as any[]),
    placement_image: props.existingPlacementFiles || ([] as any[]),
});

// Auto-generate slug from English name
watch(
    () => form.name_en,
    (newValue) => {
        if (newValue) {
            form.slug = newValue
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        } else {
            form.slug = '';
        }
    },
);

// Watch has_variants to clear fields when toggled
watch(
    () => form.has_variants,
    (newValue) => {
        if (newValue) {
            form.price = null;
        }
    },
);

const submit = () => {
    form.put(route('super-admin.products.update', props.product.id));
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: __('sidebar.products'), href: route('super-admin.products.index') },
    { title: __('datatable.edit'), href: route('super-admin.products.edit', props.product.id) },
];

const showPriceAndStockFields = computed(() => !form.has_variants);
</script>

<template>
    <ActionLayout
        type="edit"
        :title="__('datatable.products.title')"
        :description="__('datatable.products.edit_description')"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.products.index')"
        :show-card="false"
        max-width="full"
    >
        <Head :title="`${__('datatable.edit')} ${__('sidebar.products')}`" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Product Type Card -->
            <div class="rounded-lg border border-dashed border-muted-foreground/30 bg-muted/10 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                            />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold">{{ __('datatable.simple_product') }}</h3>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.simple_product_description') }}</p>
                    </div>
                    <DashboardToggle id="has_variants" v-model="form.has_variants" disabled :label="__('datatable.variants_disabled')" size="small" />
                </div>
            </div>

            <!-- English & Arabic Name -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="space-y-2">
                    <Label for="name_en" required>{{ __('datatable.name_en') }}</Label>
                    <DashboardTextInput
                        id="name_en"
                        v-model="form.name_en"
                        type="text"
                        :placeholder="__('datatable.name_en_placeholder')"
                        :error="form.errors.name_en"
                        autofocus
                        required
                    />
                    <InputError :message="form.errors.name_en" />
                    <Hint :text="__('datatable.name_en_hint')" />
                </div>

                <div class="space-y-2">
                    <Label for="name_ar" required>{{ __('datatable.name_ar') }}</Label>
                    <DashboardTextInput
                        id="name_ar"
                        v-model="form.name_ar"
                        type="text"
                        :placeholder="__('datatable.name_ar_placeholder')"
                        :error="form.errors.name_ar"
                        required
                    />
                    <InputError :message="form.errors.name_ar" />
                    <Hint :text="__('datatable.name_ar_hint')" />
                </div>
            </div>

            <!-- Slug & SKU (Auto-generated) -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="space-y-2">
                    <Label for="slug" required>{{ __('datatable.slug') }}</Label>
                    <DashboardTextInput
                        id="slug"
                        v-model="form.slug"
                        type="text"
                        :placeholder="__('datatable.slug_placeholder')"
                        :error="form.errors.slug"
                        disabled
                    />
                    <InputError :message="form.errors.slug" />
                    <Hint :text="__('datatable.slug_auto_hint')" />
                </div>

                <div class="space-y-2">
                    <Label for="sku" required>{{ __('datatable.sku') }}</Label>
                    <DashboardTextInput
                        id="sku"
                        v-model="form.sku"
                        type="text"
                        :placeholder="__('datatable.sku_placeholder')"
                        :error="form.errors.sku"
                        disabled
                    />
                    <InputError :message="form.errors.sku" />
                    <Hint :text="__('datatable.sku_hint_edit')" />
                </div>
            </div>

            <!-- Category & Quality -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="space-y-2">
                    <Label required>{{ __('datatable.category') }}</Label>
                    <DashboardSelect
                        id="category_id"
                        v-model="form.category_id"
                        :options="categories"
                        :optionLabel="optionLabel"
                        optionValue="id"
                        :placeholder="__('datatable.select_category')"
                        class="w-full"
                        :showClear="true"
                        filter
                        :filterPlaceholder="__('datatable.search')"
                    />
                    <InputError :message="form.errors.category_id" />
                    <Hint :text="__('datatable.category_hint')" />
                </div>

                <div class="space-y-2">
                    <Label required>{{ __('datatable.quality') }}</Label>
                    <DashboardSelect
                        id="quality_id"
                        v-model="form.quality_id"
                        :options="qualities"
                        :optionLabel="optionLabel"
                        optionValue="id"
                        :placeholder="__('datatable.select_quality')"
                        class="w-full"
                        :showClear="true"
                        filter
                        :filterPlaceholder="__('datatable.search')"
                    />
                    <InputError :message="form.errors.quality_id" />
                    <Hint :text="__('datatable.quality_hint')" />
                </div>
            </div>

            <!-- English & Arabic Description -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="space-y-2">
                    <Label for="description_en">{{ __('datatable.description_en') }}</Label>
                    <DashboardTextarea
                        id="description_en"
                        v-model="form.description_en"
                        :placeholder="__('datatable.description_en_placeholder')"
                        :error="form.errors.description_en"
                        :rows="4"
                    />
                    <InputError :message="form.errors.description_en" />
                </div>

                <div class="space-y-2">
                    <Label for="description_ar">{{ __('datatable.description_ar') }}</Label>
                    <DashboardTextarea
                        id="description_ar"
                        v-model="form.description_ar"
                        :placeholder="__('datatable.description_ar_placeholder')"
                        :error="form.errors.description_ar"
                        :rows="4"
                    />
                    <InputError :message="form.errors.description_ar" />
                </div>
            </div>

            <!-- Conditional Price and Stock Fields -->
            <template v-if="showPriceAndStockFields">
                <!-- Price & Stock Quantity -->
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="space-y-2">
                        <Label for="price">{{ __('datatable.price') }}</Label>
                        <DashboardTextInput
                            id="price"
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            min="0"
                            :placeholder="__('datatable.price_placeholder')"
                            :error="form.errors.price"
                        />
                        <InputError :message="form.errors.price" />
                        <Hint :text="__('datatable.price_hint')" />
                    </div>
                </div>

                <!-- Featured Image Upload -->
                <div class="space-y-2">
                    <Label for="featured_image">{{ __('datatable.featured_image') }}</Label>
                    <DashboardFileUpload id="featured_image" v-model="form.temp_files" :multiple="false" accept="image/*" context="products" />
                    <InputError :message="form.errors.temp_files" />
                    <Hint :text="__('datatable.featured_image_hint')" />
                </div>
            </template>

            <!-- Product Placement Image (Optional) -->
            <div class="space-y-2">
                <Label for="placement_image"
                    >{{ __('datatable.placement_image') }} <span class="text-xs text-muted-foreground">({{ __('datatable.optional') }})</span></Label
                >
                <DashboardFileUpload
                    id="placement_image"
                    v-model="form.placement_image"
                    :multiple="false"
                    accept="image/*"
                    context="products-placement"
                />
                <InputError :message="form.errors.placement_image" />
                <Hint :text="__('datatable.placement_image_hint')" />
            </div>

            <!-- Is New Toggle -->
            <div class="space-y-2">
                <Label for="is_new">{{ __('datatable.is_new') }}</Label>
                <DashboardToggle
                    id="is_new"
                    v-model="form.is_new"
                    :error="form.errors.is_new"
                    :label="form.is_new ? __('datatable.active') : __('datatable.inactive')"
                    :hint="__('datatable.is_new_hint')"
                />
                <InputError :message="form.errors.is_new" />
            </div>

            <!-- Status Toggle -->
            <div class="space-y-2">
                <Label for="status">{{ __('datatable.status') }}</Label>
                <DashboardToggle
                    id="status"
                    v-model="form.status"
                    :error="form.errors.status"
                    :label="form.status ? __('datatable.active') : __('datatable.inactive')"
                    :hint="__('datatable.status_hint')"
                />
                <InputError :message="form.errors.status" />
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.products.index'))" variant="secondary" :disabled="form.processing">
                    {{ __('datatable.cancel') }}
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> {{ __('datatable.save_changes') }} </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
