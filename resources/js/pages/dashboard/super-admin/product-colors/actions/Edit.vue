<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import DashboardToggle from '@/common/components/dashboards/form/DashboardToggle.vue';
import Hint from '@/common/components/dashboards/typography/Hint.vue';
import type { BreadcrumbItem } from '@core/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import InputError from '@shared/components/InputError.vue';
import { Label } from '@ui/label';
import type { ProductColor } from '../datatable/type';

const props = defineProps<{
    color: ProductColor;
}>();

// Form - Initialize with color's existing values
const form = useForm({
    name_en: props.color.name_en,
    name_ar: props.color.name_ar,
    code: props.color.code,
    status: Boolean(props.color.status),
});

// Submit handler
const submit = () => {
    form.put(route('super-admin.product-colors.update', props.color.id));
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Product Colors', href: route('super-admin.product-colors.index') },
    { title: 'Edit Color', href: route('super-admin.product-colors.edit', props.color.id) },
];
</script>

<template>
    <ActionLayout
        type="edit"
        title="Edit Product Color"
        description="Update the details below to modify the product color"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.product-colors.index')"
        :show-card="false"
        max-width="full"
        card-title="Color Information"
        card-description="Update the details below to modify the product color"
    >
        <Head title="Edit Product Color" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- English & Arabic Name -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <!-- English Name -->
                <div class="space-y-2">
                    <Label for="name_en" required>Name (English)</Label>
                    <DashboardTextInput
                        id="name_en"
                        v-model="form.name_en"
                        type="text"
                        placeholder="Enter color name in English"
                        :error="form.errors.name_en"
                        autofocus
                        required
                    />
                    <InputError :message="form.errors.name_en" />
                    <Hint text="Enter the color name in English (e.g., Red, Blue, Green)." />
                </div>

                <!-- Arabic Name -->
                <div class="space-y-2">
                    <Label for="name_ar" required>Name (Arabic)</Label>
                    <DashboardTextInput
                        id="name_ar"
                        v-model="form.name_ar"
                        type="text"
                        placeholder="أدخل اسم اللون بالعربية"
                        :error="form.errors.name_ar"
                        required
                    />
                    <InputError :message="form.errors.name_ar" />
                    <Hint text="أدخل اسم اللون بالعربية (مثال: أحمر، أزرق، أخضر)." />
                </div>
            </div>

            <!-- Color Code -->
            <div class="space-y-2">
                <Label for="code" required>Color Code</Label>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <DashboardTextInput id="code" v-model="form.code" type="text" placeholder="#000000" :error="form.errors.code" required />
                        <InputError :message="form.errors.code" />
                        <Hint text="Enter the hexadecimal color code (e.g., #FF5733)." />
                    </div>
                    <div class="flex items-start gap-2">
                        <input v-model="form.code" type="color" class="h-10 w-20 cursor-pointer rounded border border-input" />
                        <div class="h-10 w-10 rounded border border-input" :style="{ backgroundColor: form.code }"></div>
                    </div>
                </div>
            </div>

            <!-- Status Toggle -->
            <div class="space-y-2">
                <Label for="status">Status</Label>
                <DashboardToggle
                    id="status"
                    v-model="form.status"
                    :error="form.errors.status"
                    :label="form.status ? 'Active' : 'Inactive'"
                    :hint="form.status ? 'The color is active and visible.' : 'The color is inactive and hidden.'"
                />
                <InputError :message="form.errors.status" />
                <Hint text="Set whether the color is active or inactive." />
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.product-colors.index'))" variant="secondary" :disabled="form.processing">
                    Cancel
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> Update Color </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
