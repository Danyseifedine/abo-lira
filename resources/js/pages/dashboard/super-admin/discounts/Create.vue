<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardDatePicker from '@/common/components/dashboards/form/DashboardDatePicker.vue';
import DashboardSelect from '@/common/components/dashboards/form/DashboardSelect.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import DashboardToggle from '@/common/components/dashboards/form/DashboardToggle.vue';
import Hint from '@/common/components/dashboards/typography/Hint.vue';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import InputError from '@shared/components/InputError.vue';
import { Label } from '@ui/label';
import { computed, ref } from 'vue';

interface ProductOption {
    id: number;
    name: string;
    sku: string;
}

const props = defineProps<{
    products: ProductOption[];
}>();

const form = useForm({
    product_id: null as number | null,
    discount_price: null as number | null,
    has_limited_time_discount: true,
    discount_start_date: null as Date | string | null,
    discount_end_date: null as Date | string | null,
});

const submit = () => {
    form.post(route('super-admin.discounts.store'));
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: __('datatable.discounts.title'), href: route('super-admin.discounts.index') },
    { title: __('datatable.create') + ' ' + __('datatable.discount'), href: route('super-admin.discounts.create') },
];

// Show date fields only when has_limited_time_discount is true
const showDateFields = computed(() => form.has_limited_time_discount);
</script>

<template>
    <ActionLayout
        type="create"
        :title="__('datatable.create') + ' ' + __('datatable.discount')"
        :description="__('datatable.create_discount_description')"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.discounts.index')"
        :show-card="false"
        max-width="full"
    >
        <Head :title="__('datatable.create') + ' ' + __('datatable.discount')" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Product Selection -->
            <div class="space-y-2">
                <Label for="product_id" required>{{ __('datatable.product') }}</Label>
                <DashboardSelect
                    id="product_id"
                    v-model="form.product_id"
                    :options="products"
                    optionLabel="name"
                    optionValue="id"
                    :placeholder="__('datatable.select_product')"
                    class="w-full"
                    :error="form.errors.product_id ?? null"
                    filter
                    :filterPlaceholder="__('datatable.search') + '...'"
                />
                <InputError :message="form.errors.product_id" />
                <Hint :text="__('datatable.select_product_without_discount')" />
            </div>

            <!-- Discount Price -->
            <div class="space-y-2">
                <Label for="discount_price" required>{{ __('datatable.discount_price') }}</Label>
                <DashboardTextInput
                    id="discount_price"
                    v-model="form.discount_price"
                    type="number"
                    step="0.01"
                    min="0"
                    :placeholder="__('datatable.enter_discount_price')"
                    :error="form.errors.discount_price ?? null"
                    autofocus
                />
                <InputError :message="form.errors.discount_price" />
                <Hint :text="__('datatable.discount_price_hint')" />
            </div>

            <!-- Has Limited Time Discount Toggle -->
            <div class="space-y-2">
                <Label for="has_limited_time_discount">{{ __('datatable.has_limited_time_discount') }}</Label>
                <DashboardToggle
                    id="has_limited_time_discount"
                    v-model="form.has_limited_time_discount"
                    :error="form.errors.has_limited_time_discount"
                    :label="form.has_limited_time_discount ? __('datatable.yes') : __('datatable.no')"
                    :hint="__('datatable.has_limited_time_discount_hint')"
                />
                <InputError :message="form.errors.has_limited_time_discount" />
            </div>

            <!-- Date Fields (shown only when toggle is ON) -->
            <div v-if="showDateFields" class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <!-- Discount Start Date -->
                <div class="space-y-2">
                    <Label for="discount_start_date" required>{{ __('datatable.discount_start_date') }}</Label>
                    <DashboardDatePicker
                        id="discount_start_date"
                        v-model="form.discount_start_date"
                        :placeholder="__('datatable.select_start_date')"
                        :error="form.errors.discount_start_date ?? null"
                        icon-display="input"
                    />
                    <InputError :message="form.errors.discount_start_date" />
                </div>

                <!-- Discount End Date -->
                <div class="space-y-2">
                    <Label for="discount_end_date" required>{{ __('datatable.discount_end_date') }}</Label>
                    <DashboardDatePicker
                        id="discount_end_date"
                        v-model="form.discount_end_date"
                        :placeholder="__('datatable.select_end_date')"
                        :min-date="form.discount_start_date ? new Date(form.discount_start_date) : undefined"
                        :error="form.errors.discount_end_date ?? null"
                        icon-display="input"
                    />
                    <InputError :message="form.errors.discount_end_date" />
                    <Hint :text="__('datatable.discount_end_date_hint')" />
                </div>
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.discounts.index'))" variant="secondary" :disabled="form.processing">
                    {{ __('datatable.cancel') }}
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default">
                    {{ __('datatable.create') }}
                </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>

