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
import type { ProductQuality } from '../datatable/type';

const props = defineProps<{
    quality: ProductQuality;
}>();

// Form - Initialize with quality's existing values
const form = useForm({
    name_en: props.quality.name_en,
    name_ar: props.quality.name_ar,
    slug: props.quality.slug,
    status: Boolean(props.quality.status),
});

// Submit handler
const submit = () => {
    form.put(route('super-admin.product-qualities.update', props.quality.id));
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: __('datatable.product_qualities.title'), href: route('super-admin.product-qualities.index') },
    { title: __('datatable.edit_quality'), href: route('super-admin.product-qualities.edit', props.quality.id) },
];
</script>

<template>
    <ActionLayout
        type="edit"
        :title="__('datatable.edit_product_quality')"
        :description="__('datatable.update_the_details_below_to_modify_the_product_quality')"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.product-qualities.index')"
        :show-card="false"
        max-width="full"
        :card-title="__('datatable.quality_information')"
        :card-description="__('datatable.update_the_details_below_to_modify_the_product_quality')"
    >
        <Head :title="__('datatable.edit_product_quality')" />

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
                        :placeholder="__('datatable.enter_quality_name_in_english')"
                        :error="form.errors.name_en"
                        autofocus
                        required
                    />
                    <InputError :message="form.errors.name_en" />
                    <Hint :text="__('datatable.enter_quality_name_in_english_example')" />
                </div>

                <!-- Arabic Name -->
                <div class="space-y-2">
                    <Label for="name_ar" required>{{ __('datatable.name_ar') }}</Label>
                    <DashboardTextInput
                        id="name_ar"
                        v-model="form.name_ar"
                        type="text"
                        :placeholder="__('datatable.enter_quality_name_in_arabic')"
                        :error="form.errors.name_ar"
                        required
                    />
                    <InputError :message="form.errors.name_ar" />
                    <Hint :text="__('datatable.enter_quality_name_in_arabic_example')" />
                </div>
            </div>

            <!-- Slug -->
            <div class="space-y-2">
                <Label for="slug">{{ __('datatable.slug') }}</Label>
                <DashboardTextInput id="slug" v-model="form.slug" type="text" :placeholder="__('datatable.enter_slug')" :error="form.errors.slug" />
                <InputError :message="form.errors.slug" />
                <Hint :text="__('datatable.slug_hint')" />
            </div>

            <!-- Status Toggle -->
            <div class="space-y-2">
                <Label for="status">{{ __('datatable.status') }}</Label>
                <DashboardToggle
                    id="status"
                    v-model="form.status"
                    :error="form.errors.status"
                    :label="form.status ? __('datatable.active') : __('datatable.inactive')"
                    :hint="form.status ? __('datatable.the_quality_is_active_and_visible') : __('datatable.the_quality_is_inactive_and_hidden')"
                />
                <InputError :message="form.errors.status" />
                <Hint :text="__('datatable.set_whether_the_quality_is_active_or_inactive')" />
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.product-qualities.index'))" variant="secondary" :disabled="form.processing">
                    {{ __('datatable.cancel') }}
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> {{ __('datatable.update_quality') }} </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
