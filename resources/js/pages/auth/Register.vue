<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardMaskedInput from '@/common/components/dashboards/form/DashboardMaskedInput.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@shared/components/InputError.vue';
import TextLink from '@shared/components/TextLink.vue';
import AuthBase from '@shared/layouts/GuestLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="Join Us Today" description="Create your account in just a few steps" :show-logo="false">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="space-y-2">
                <DashboardTextInput
                    label="Full Name"
                    id="name"
                    type="text"
                    :tabindex="1"
                    autofocus
                    autocomplete="name"
                    v-model="form.name"
                    placeholder="John Doe"
                    :error="form.errors.name"
                />
                <InputError :message="form.errors.name" />
            </div>

            <div class="space-y-2">
                <DashboardTextInput
                    label="Email Address"
                    id="email"
                    type="email"
                    :tabindex="2"
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="email@example.com"
                    :error="form.errors.email"
                />
                <InputError :message="form.errors.email" />
            </div>
            <div class="space-y-2">
                <DashboardMaskedInput
                    label="Password"
                    id="password"
                    type="password"
                    :tabindex="3"
                    autocomplete="new-password"
                    v-model="form.password"
                    placeholder="Create a strong password"
                    :error="form.errors.password"
                />
                <InputError :message="form.errors.password" />
            </div>
            <div class="space-y-2">
                <DashboardMaskedInput
                    label="Confirm Password"
                    id="password_confirmation"
                    type="password"
                    :tabindex="4"
                    autocomplete="new-password"
                    v-model="form.password_confirmation"
                    placeholder="Confirm your password"
                    :error="form.errors.password_confirmation"
                />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <DashboardButton type="submit" size="lg" class="mt-4 w-full" :loading="form.processing"> Create Account </DashboardButton>

            <div class="mt-4 text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="ml-1 font-medium text-primary hover:underline" :tabindex="6">Sign in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
