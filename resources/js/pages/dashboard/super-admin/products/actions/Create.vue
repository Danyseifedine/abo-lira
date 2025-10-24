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

defineProps<{
    categories: ProductCategory[];
    qualities: ProductQuality[];
}>();

const form = useForm({
    name_en: '',
    name_ar: '',
    slug: '',
    description_en: '',
    description_ar: '',
    category_id: null as number | null,
    quality_id: null as number | null,
    sku: '',
    price: null as number | null,
    stock_quantity: null as number | null,
    out_of_stock: false,
    has_variants: false,
    is_new: false,
    featured: false,
    meta_title_en: '',
    meta_title_ar: '',
    meta_description_en: '',
    meta_description_ar: '',
    status: true,
    images: [] as File[],
});

// Auto-generate slug from English name
watch(
    () => form.name_en,
    (newValue) => {
        if (newValue && !form.slug) {
            form.slug = newValue
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    },
);

// Watch has_variants to clear fields when toggled
watch(
    () => form.has_variants,
    (newValue) => {
        if (newValue) {
            form.price = null;
            form.stock_quantity = null;
            form.out_of_stock = false;
        }
    },
);

const handleImageChange = (files: File[]) => {
    form.images = files;
};

const submit = () => {
    form.post(route('super-admin.products.store'));
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: __('sidebar.products'), href: route('super-admin.products.index') },
    { title: __('datatable.add'), href: route('super-admin.products.create') },
];

const showPriceAndStockFields = computed(() => !form.has_variants);
</script>

<template>
    <ActionLayout
        type="create"
        :title="__('datatable.products.title')"
        :description="__('datatable.products.create_description')"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.products.index')"
        :show-card="false"
        max-width="full"
    >
        <Head :title="`${__('datatable.add')} ${__('sidebar.products')}`" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
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

            <!-- Slug & SKU -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="space-y-2">
                    <Label for="slug" required>{{ __('datatable.slug') }}</Label>
                    <DashboardTextInput
                        id="slug"
                        v-model="form.slug"
                        type="text"
                        :placeholder="__('datatable.slug_placeholder')"
                        :error="form.errors.slug"
                        required
                    />
                    <InputError :message="form.errors.slug" />
                    <Hint :text="__('datatable.slug_hint')" />
                </div>

                <div class="space-y-2">
                    <Label for="sku">{{ __('datatable.sku') }}</Label>
                    <DashboardTextInput
                        id="sku"
                        v-model="form.sku"
                        type="text"
                        :placeholder="__('datatable.sku_placeholder')"
                        :error="form.errors.sku"
                    />
                    <InputError :message="form.errors.sku" />
                    <Hint :text="__('datatable.sku_hint')" />
                </div>
            </div>

            <!-- Category & Quality -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="space-y-2">
                    <Label for="category_id" required>{{ __('datatable.category') }}</Label>
                    <DashboardSelect
                        id="category_id"
                        v-model="form.category_id"
                        :options="categories"
                        :optionLabel="page.props.locale === 'ar' ? 'name_ar' : 'name_en'"
                        optionValue="id"
                        :placeholder="__('datatable.select_category')"
                        class="w-full"
                        :showClear="true"
                        filter
                        :error="form.errors.category_id ?? null"
                        :filterPlaceholder="__('datatable.search')"
                    />
                    <InputError :message="form.errors.category_id" />
                    <Hint :text="__('datatable.category_hint')" />
                </div>

                <div class="space-y-2">
                    <Label for="quality_id" required>{{ __('datatable.quality') }}</Label>
                    <DashboardSelect
                        id="quality_id"
                        v-model="form.quality_id"
                        :options="qualities"
                        :optionLabel="page.props.locale === 'ar' ? 'name_ar' : 'name_en'"
                        optionValue="id"
                        :placeholder="__('datatable.select_quality')"
                        class="w-full"
                        :showClear="true"
                        filter
                        :error="form.errors.quality_id ?? null"
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

            <!-- Has Variants Toggle -->
            <div class="space-y-2">
                <Label for="has_variants">{{ __('datatable.has_variants') }}</Label>
                <DashboardToggle
                    id="has_variants"
                    v-model="form.has_variants"
                    :error="form.errors.has_variants"
                    :label="form.has_variants ? __('datatable.active') : __('datatable.inactive')"
                    :hint="__('datatable.has_variants_hint')"
                />
                <InputError :message="form.errors.has_variants" />
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

                    <div class="space-y-2">
                        <Label for="stock_quantity">{{ __('datatable.stock_quantity') }}</Label>
                        <DashboardTextInput
                            id="stock_quantity"
                            v-model="form.stock_quantity"
                            type="number"
                            min="0"
                            :placeholder="__('datatable.stock_quantity_placeholder')"
                            :error="form.errors.stock_quantity"
                        />
                        <InputError :message="form.errors.stock_quantity" />
                        <Hint :text="__('datatable.stock_quantity_hint')" />
                    </div>
                </div>

                <!-- Out of Stock Toggle -->
                <div class="space-y-2">
                    <Label for="out_of_stock">{{ __('datatable.out_of_stock') }}</Label>
                    <DashboardToggle
                        id="out_of_stock"
                        v-model="form.out_of_stock"
                        :error="form.errors.out_of_stock"
                        :label="form.out_of_stock ? __('datatable.active') : __('datatable.inactive')"
                        :hint="__('datatable.out_of_stock_hint')"
                    />
                    <InputError :message="form.errors.out_of_stock" />
                </div>

                <!-- Image Upload -->
                <div class="space-y-2">
                    <Label for="images">{{ __('datatable.images') }}</Label>
                    <DashboardFileUpload id="images" :multiple="true" accept="image/*" @change="handleImageChange" :error="form.errors.images" />
                    <InputError :message="form.errors.images" />
                    <Hint :text="__('datatable.images_hint')" />
                </div>
            </template>

            <!-- Is New & Featured Toggles -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
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

                <div class="space-y-2">
                    <Label for="featured">{{ __('datatable.featured') }}</Label>
                    <DashboardToggle
                        id="featured"
                        v-model="form.featured"
                        :error="form.errors.featured"
                        :label="form.featured ? __('datatable.active') : __('datatable.inactive')"
                        :hint="__('datatable.featured_hint')"
                    />
                    <InputError :message="form.errors.featured" />
                </div>
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
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> {{ __('datatable.create') }} </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
