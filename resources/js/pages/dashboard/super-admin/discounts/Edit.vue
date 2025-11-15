<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardDatePicker from '@/common/components/dashboards/form/DashboardDatePicker.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import DashboardToggle from '@/common/components/dashboards/form/DashboardToggle.vue';
import Hint from '@/common/components/dashboards/typography/Hint.vue';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import InputError from '@shared/components/InputError.vue';
import { Label } from '@ui/label';
import { computed } from 'vue';
import type { DiscountProduct } from '../datatable/type';
import { parseDate } from '@/core/utils/parsers';

const props = defineProps<{
    product: DiscountProduct;
}>();

const form = useForm({
    discount_price: props.product.discount_price ? Number(props.product.discount_price) : null,
    has_limited_time_discount: props.product.has_limited_time_discount ?? true,
    discount_start_date: props.product.discount_start_date ? parseDate(props.product.discount_start_date) : null,
    discount_end_date: props.product.discount_end_date ? parseDate(props.product.discount_end_date) : null,
});

const submit = () => {
    form.put(route('super-admin.discounts.update', props.product.id));
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: __('datatable.discounts.title'), href: route('super-admin.discounts.index') },
    { title: props.product.name, href: route('super-admin.discounts.show', props.product.id) },
    { title: __('datatable.edit'), href: route('super-admin.discounts.edit', props.product.id) },
];

// Show date fields only when has_limited_time_discount is true
const showDateFields = computed(() => form.has_limited_time_discount);
</script>

<template>
    <ActionLayout
        type="edit"
        :title="__('datatable.edit') + ' ' + __('datatable.discount')"
        :description="__('datatable.edit_discount_description')"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.discounts.show', product.id)"
        :show-card="false"
        max-width="full"
    >
        <Head :title="__('datatable.edit') + ' ' + __('datatable.discount')" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Product Info (Read-only) -->
            <div class="space-y-2">
                <Label>{{ __('datatable.product') }}</Label>
                <div class="rounded-md border bg-muted/50 p-3">
                    <p class="font-semibold">{{ product.name }}</p>
                    <p class="text-sm text-muted-foreground">{{ __('datatable.sku') }}: {{ product.sku }}</p>
                </div>
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
                <DashboardButton @click="router.visit(route('super-admin.discounts.show', product.id))" variant="secondary" :disabled="form.processing">
                    {{ __('datatable.cancel') }}
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default">
                    {{ __('datatable.update') }}
                </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>

