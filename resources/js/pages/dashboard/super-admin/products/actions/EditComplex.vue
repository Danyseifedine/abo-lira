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
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

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

interface ProductColor {
    id: number;
    name_en: string;
    name_ar: string;
    code: string;
}

interface ProductSize {
    id: number;
    name_en: string;
    name_ar: string;
}

// Get option label based on locale
const getOptionLabel = () => {
    return page.props.locale === 'ar' ? 'name_ar' : 'name_en';
};

interface ProductVariant {
    id: number;
    sku: string;
    color_id: number | null;
    size_id: number | null;
    price: number;
    status: boolean;
}

interface Product {
    id: number;
    sku: string;
    name_en: string;
    name_ar: string;
    slug: string;
    description_en?: string | null;
    description_ar?: string | null;
    category_id: number;
    quality_id: number;
    has_variants: boolean;
    status: boolean;
    variants: ProductVariant[];
}

interface Variant {
    id: string | number;
    color_id: number | null;
    size_id: number | null;
    price: number | null;
    status: boolean;
    temp_files: any[];
    existing_media?: any[];
}

const props = defineProps<{
    product: Product;
    categories: ProductCategory[];
    qualities: ProductQuality[];
    colors: ProductColor[];
    sizes: ProductSize[];
    existingVariants: any[];
    existingPlacementFiles: any[];
    existingFiles: any[];
}>();

// Variant type toggles (not in database) - Auto-detect from existing variants
const determineVariantType = () => {
    const hasColor = props.existingVariants.some((v) => v.color_id);
    const hasSize = props.existingVariants.some((v) => v.size_id);

    if (hasColor && hasSize) return 'both';
    if (hasSize) return 'size';
    return 'color';
};

const variantType = ref<'color' | 'size' | 'both'>(determineVariantType());

// Initialize variants from existing data
const variants = ref<Variant[]>(
    props.existingVariants.map((v) => ({
        id: v.id,
        color_id: v.color_id,
        size_id: v.size_id,
        price: v.price,
        status: v.status,
        temp_files: v.existing_media || [],
        existing_media: v.existing_media || [],
    })),
);

const form = useForm({
    name_en: props.product.name_en,
    name_ar: props.product.name_ar,
    slug: props.product.slug,
    description_en: props.product.description_en || '',
    description_ar: props.product.description_ar || '',
    category_id: props.product.category_id,
    quality_id: props.product.quality_id,
    sku: props.product.sku,
    has_variants: true, // Always true for complex products
    status: props.product.status,
    temp_files: props.existingFiles || [], // Featured product image (for size-only variants)
    placement_image: props.existingPlacementFiles || [], // Global placement image
    variants: [] as any[],
});

// Note: Slug and SKU are not auto-generated when editing

// Add new variant
const addVariant = () => {
    variants.value.push({
        id: `variant-${Date.now()}`,
        color_id: null,
        size_id: null,
        price: null,
        status: true,
        temp_files: [],
    });
};

// Remove variant
const removeVariant = (index: number) => {
    variants.value.splice(index, 1);
};

// Check if variant type is selected
const showColorField = computed(() => variantType.value === 'color' || variantType.value === 'both');
const showSizeField = computed(() => variantType.value === 'size' || variantType.value === 'both');
const showImageField = computed(() => variantType.value === 'color' || variantType.value === 'both');

const submit = () => {
    // Map variants to form data
    form.variants = variants.value.map((variant) => ({
        id: typeof variant.id === 'number' ? variant.id : null, // Include ID if existing variant
        color_id: variant.color_id,
        size_id: variant.size_id,
        price: variant.price,
        status: variant.status,
        temp_files: variant.temp_files.filter((file: any) => file.temp_path), // Only new files
        existing_media: variant.existing_media || [], // Keep existing media
    }));

    form.put(route('super-admin.products.update-complex', props.product.id), {
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
        onSuccess: () => {
            console.log('Product updated successfully');
        },
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: __('sidebar.products'), href: route('super-admin.products.index') },
    { title: props.product.name_en, href: '#' },
];
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
        <Head :title="`${__('datatable.edit')} ${props.product.name_en}`" />

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
                                d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"
                            />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold">{{ __('datatable.complex_product') }}</h3>
                        <p class="text-xs text-muted-foreground">{{ __('datatable.complex_product_description') }}</p>
                    </div>
                    <DashboardToggle id="has_variants" v-model="form.has_variants" disabled :label="__('datatable.variants_enabled')" size="small" />
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
                    <Hint :text="__('datatable.sku_auto_hint')" />
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
                        :optionLabel="getOptionLabel()"
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
                    <Label required>{{ __('datatable.quality') }}</Label>
                    <DashboardSelect
                        id="quality_id"
                        v-model="form.quality_id"
                        :options="qualities"
                        :optionLabel="getOptionLabel()"
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

            <!-- Placement Image (Optional) -->
            <div class="space-y-2">
                <Label for="placement_image">{{ __('datatable.placement_image') }}</Label>
                <DashboardFileUpload
                    id="placement_image"
                    v-model="form.placement_image"
                    :multiple="false"
                    accept="image/*"
                    context="product-placement"
                />
                <Hint :text="__('datatable.placement_image_hint')" />
                <InputError :message="form.errors.placement_image" />
            </div>

            <!-- Variant Type Selection -->
            <div class="space-y-4 rounded-lg border border-dashed border-primary/30 bg-primary/5 p-4">
                <div>
                    <h3 class="text-sm font-semibold">{{ __('datatable.variant_type') }}</h3>
                    <p class="text-xs text-muted-foreground">{{ __('datatable.variant_type_hint') }}</p>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <input type="radio" id="variant_color" :value="'color'" v-model="variantType" class="h-4 w-4" />
                        <Label for="variant_color" class="cursor-pointer font-normal">{{ __('datatable.color_only') }}</Label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="radio" id="variant_size" :value="'size'" v-model="variantType" class="h-4 w-4" />
                        <Label for="variant_size" class="cursor-pointer font-normal">{{ __('datatable.size_only') }}</Label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="radio" id="variant_both" :value="'both'" v-model="variantType" class="h-4 w-4" />
                        <Label for="variant_both" class="cursor-pointer font-normal">{{ __('datatable.color_and_size') }}</Label>
                    </div>
                </div>
            </div>

            <!-- Product Image (for Size Only variants) -->
            <div v-if="variantType === 'size'" class="space-y-2">
                <Label for="temp_files">{{ __('datatable.featured_image') }}</Label>
                <DashboardFileUpload id="temp_files" v-model="form.temp_files" :multiple="false" accept="image/*" context="products" />
                <Hint :text="__('datatable.featured_image_hint')" />
                <InputError :message="form.errors.temp_files" />
            </div>

            <!-- Variants Repeater -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">{{ __('datatable.product_variants') }}</h3>
                        <p class="text-sm text-muted-foreground">{{ __('datatable.product_variants_hint') }}</p>
                    </div>
                    <DashboardButton type="button" @click="addVariant" variant="outline" size="sm">
                        <Plus class="mr-2 h-4 w-4" />
                        {{ __('datatable.add_variant') }}
                    </DashboardButton>
                </div>
                <InputError :message="form.errors.variants" />

                <!-- Variants List -->
                <div v-if="variants.length === 0" class="rounded-lg border border-dashed border-muted-foreground/30 bg-muted/10 p-8 text-center">
                    <p class="text-sm text-muted-foreground">{{ __('datatable.no_variants_added') }}</p>
                </div>

                <div v-for="(variant, index) in variants" :key="variant.id" class="space-y-4 rounded-lg border p-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-semibold">{{ __('datatable.variant') }} #{{ index + 1 }}</h4>
                        <DashboardButton type="button" @click="removeVariant(index)" variant="ghost" size="sm">
                            <Trash2 class="h-4 w-4 text-destructive" />
                        </DashboardButton>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        <!-- Color Select (if color or both) -->
                        <div v-if="showColorField" class="space-y-2">
                            <Label required>{{ __('datatable.color') }}</Label>
                            <DashboardSelect
                                :id="`color_${index}`"
                                v-model="variant.color_id"
                                :options="colors"
                                :optionLabel="getOptionLabel()"
                                optionValue="id"
                                :placeholder="__('datatable.select_color')"
                                class="w-full"
                                :showClear="true"
                                filter
                                :filterPlaceholder="__('datatable.search')"
                            />
                        </div>

                        <!-- Size Select (if size or both) -->
                        <div v-if="showSizeField" class="space-y-2">
                            <Label required>{{ __('datatable.size') }}</Label>
                            <DashboardSelect
                                :id="`size_${index}`"
                                v-model="variant.size_id"
                                :options="sizes"
                                :optionLabel="getOptionLabel()"
                                optionValue="id"
                                :placeholder="__('datatable.select_size')"
                                class="w-full"
                                :showClear="true"
                                filter
                                :filterPlaceholder="__('datatable.search')"
                            />
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                            <Label :for="`price_${index}`" required>{{ __('datatable.price') }}</Label>
                            <DashboardTextInput
                                :id="`price_${index}`"
                                v-model="variant.price"
                                type="number"
                                step="0.01"
                                :placeholder="__('datatable.price_placeholder')"
                            />
                        </div>
                    </div>

                    <!-- Image Upload (if color or both) -->
                    <div v-if="showImageField" class="space-y-2">
                        <Label :for="`image_${index}`">{{ __('datatable.variant_image') }}</Label>
                        <DashboardFileUpload
                            :id="`image_${index}`"
                            v-model="variant.temp_files"
                            :multiple="false"
                            accept="image/*"
                            context="product-variants"
                        />
                        <Hint :text="__('datatable.variant_image_hint')" />
                    </div>

                    <!-- Status Toggle -->
                    <div class="space-y-2">
                        <Label :for="`variant_status_${index}`">{{ __('datatable.status') }}</Label>
                        <DashboardToggle
                            :id="`variant_status_${index}`"
                            v-model="variant.status"
                            :label="variant.status ? __('datatable.active') : __('datatable.inactive')"
                            size="small"
                        />
                    </div>
                </div>
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.products.index'))" variant="secondary" :disabled="form.processing">
                    {{ __('datatable.cancel') }}
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> {{ __('datatable.update') }} </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
