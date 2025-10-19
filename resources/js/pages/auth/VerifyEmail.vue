<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextLink from '@shared/components/TextLink.vue';
import GuestLayout from '@shared/layouts/GuestLayout.vue';
import { Mail } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};
</script>

<template>
    <GuestLayout
        title="Verify email"
        description="Please verify your email address by clicking on the link we just emailed to you."
        :show-logo="false"
    >
        <Head title="Email verification" />

        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit" class="space-y-6 text-center">
            <div class="flex justify-center">
                <Mail class="h-12 w-12 text-primary" />
            </div>

            <DashboardButton type="submit" size="lg" class="w-full" :loading="form.processing"> Resend verification email </DashboardButton>

            <TextLink :href="route('logout')" method="post" as="button" class="mx-auto block text-sm"> Log out </TextLink>
        </form>
    </GuestLayout>
</template>
