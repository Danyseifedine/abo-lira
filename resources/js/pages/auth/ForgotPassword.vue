<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@shared/components/InputError.vue';
import TextLink from '@shared/components/TextLink.vue';
import GuestLayout from '@shared/layouts/GuestLayout.vue';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout title="Forgot password" description="Enter your email to receive a password reset link" :show-logo="false">
        <Head title="Forgot password" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

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

                <DashboardButton type="submit" size="lg" class="w-full" :loading="form.processing"> Email password reset link </DashboardButton>
            </div>
        </form>

        <div class="mt-6 text-center text-sm text-muted-foreground">
            <span>Or, return to </span>
            <TextLink :href="route('login')">log in</TextLink>
        </div>
    </GuestLayout>
</template>
