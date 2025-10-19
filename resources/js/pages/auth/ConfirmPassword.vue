<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@shared/components/InputError.vue';
import GuestLayout from '@shared/layouts/GuestLayout.vue';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout
        title="Confirm your password"
        description="This is a secure area of the application. Please confirm your password before continuing."
        :show-logo="false"
    >
        <Head title="Confirm password" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="space-y-4">
                <div class="space-y-2">
                    <DashboardTextInput
                        label="Password"
                        id="password"
                        type="password"
                        required
                        autofocus
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Enter your password"
                        :error="form.errors.password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="pt-2">
                    <DashboardButton type="submit" size="lg" class="w-full" :loading="form.processing"> Confirm Password </DashboardButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
