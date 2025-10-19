<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@shared/components/InputError.vue';
import GuestLayout from '@shared/layouts/GuestLayout.vue';

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout title="Reset password" description="Please enter your new password below" :show-logo="false">
        <Head title="Reset password" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="space-y-4">
                <div class="space-y-2">
                    <DashboardTextInput
                        label="Email Address"
                        id="email"
                        type="email"
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                        :error="form.errors.email"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="space-y-2">
                    <DashboardTextInput
                        label="Password"
                        id="password"
                        type="password"
                        :tabindex="2"
                        autocomplete="new-password"
                        v-model="form.password"
                        placeholder="New password"
                        :error="form.errors.password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="space-y-2">
                    <DashboardTextInput
                        label="Confirm Password"
                        id="password_confirmation"
                        type="password"
                        :tabindex="3"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Confirm password"
                        :error="form.errors.password_confirmation"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <DashboardButton type="submit" size="lg" class="w-full" :loading="form.processing"> Reset Password </DashboardButton>
            </div>
        </form>
    </GuestLayout>
</template>
