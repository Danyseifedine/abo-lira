<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import DashboardToggle from '@/common/components/dashboards/form/DashboardToggle.vue';
import Hint from '@/common/components/dashboards/typography/Hint.vue';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import InputError from '@shared/components/InputError.vue';
import { Label } from '@ui/label';

// Form - Initialize with empty values
const form = useForm({
    name_en: '',
    name_ar: '',
    status: true,
});

// Submit handler
const submit = () => {
    form.post(route('super-admin.product-sizes.store'));
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: __('datatable.product_sizes.title'), href: route('super-admin.product-sizes.index') },
    { title: __('datatable.create_size'), href: route('super-admin.product-sizes.create') },
];
</script>

<template>
    <ActionLayout
        type="create"
        :title="__('datatable.create_product_size')"
        :description="__('datatable.fill_in_the_details_below_to_create_a_new_product_size')"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.product-sizes.index')"
        :show-card="false"
        max-width="full"
        :card-title="__('datatable.size_information')"
        :card-description="__('datatable.fill_in_the_details_below_to_create_a_new_product_size')"
    >
        <Head :title="__('datatable.create_product_size')" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- English & Arabic Name -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <!-- English Name -->
                <div class="space-y-2">
                    <Label for="name_en" required>{{ __('datatable.name_en') }}</Label>
                    <DashboardTextInput
                        id="name_en"
                        v-model="form.name_en"
                        type="text"
                        :placeholder="__('datatable.enter_size_name_in_english')"
                        :error="form.errors.name_en"
                        autofocus
                        required
                    />
                    <InputError :message="form.errors.name_en" />
                    <Hint :text="__('datatable.enter_size_name_in_english_example')" />
                </div>

                <!-- Arabic Name -->
                <div class="space-y-2">
                    <Label for="name_ar" required>{{ __('datatable.name_ar') }}</Label>
                    <DashboardTextInput
                        id="name_ar"
                        v-model="form.name_ar"
                        type="text"
                        :placeholder="__('datatable.enter_size_name_in_arabic')"
                        :error="form.errors.name_ar"
                        required
                    />
                    <InputError :message="form.errors.name_ar" />
                    <Hint :text="__('datatable.enter_size_name_in_arabic_example')" />
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
                    :hint="form.status ? __('datatable.the_size_is_active_and_visible') : __('datatable.the_size_is_inactive_and_hidden')"
                />
                <InputError :message="form.errors.status" />
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.product-sizes.index'))" variant="secondary" :disabled="form.processing">
                    {{ __('datatable.cancel') }}
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> {{ __('datatable.create') }} </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
