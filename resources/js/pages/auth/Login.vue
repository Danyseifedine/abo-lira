<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@shared/components/InputError.vue';
import TextLink from '@shared/components/TextLink.vue';
import AuthBase from '@shared/layouts/GuestLayout.vue';
import { Checkbox } from '@shared/ui/checkbox';
import { Label } from '@shared/ui/label';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

// Handler for Google login button
const loginWithGoogle = () => {
    window.location.href = route('keychain.redirect', { provider: 'google' });
};
</script>

<template>
    <AuthBase title="Welcome Back" description="Sign in to continue to your account" :show-logo="false">
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-6 rounded-md bg-green-50 p-3 text-center text-sm font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="space-y-4">
                <div class="space-y-2">
                    <DashboardTextInput
                        label="Email address"
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
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="••••••••"
                        :error="form.errors.password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between" :tabindex="3">
                    <Label for="remember" class="flex items-center space-x-2 text-sm">
                        <Checkbox id="remember" v-model:checked="form.remember" :tabindex="4" />
                        <span>Remember me</span>
                    </Label>
                    <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-xs font-medium hover:underline" :tabindex="5">
                        Forgot password?
                    </TextLink>
                </div>

                <DashboardButton type="submit" size="lg" class="mt-4 w-full" :loading="form.processing"> Sign In </DashboardButton>

                <!-- Google Login Button -->
                <DashboardButton type="button" size="lg" variant="glass" class="w-full" @click="loginWithGoogle">
                    <template #icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 48 48">
                            <g>
                                <path
                                    fill="#4285F4"
                                    d="M24 9.5c3.54 0 6.7 1.22 9.2 3.23l6.9-6.9C36.64 2.36 30.74 0 24 0 14.82 0 6.73 5.48 2.69 13.44l8.06 6.26C12.7 13.1 17.9 9.5 24 9.5z"
                                />
                                <path
                                    fill="#34A853"
                                    d="M46.1 24.55c0-1.64-.15-3.22-.42-4.74H24v9.01h12.4c-.54 2.9-2.18 5.36-4.65 7.01l7.18 5.59C43.98 37.13 46.1 31.36 46.1 24.55z"
                                />
                                <path
                                    fill="#FBBC05"
                                    d="M10.75 28.19a14.5 14.5 0 0 1 0-8.38l-8.06-6.26A23.97 23.97 0 0 0 0 24c0 3.82.92 7.44 2.69 10.81l8.06-6.62z"
                                />
                                <path
                                    fill="#EA4335"
                                    d="M24 48c6.48 0 11.93-2.15 15.9-5.86l-7.18-5.59c-2.01 1.35-4.6 2.16-8.72 2.16-6.1 0-11.3-3.6-13.25-8.81l-8.06 6.62C6.73 42.52 14.82 48 24 48z"
                                />
                            </g>
                        </svg>
                    </template>
                    Sign in with Google
                </DashboardButton>
            </div>

            <div class="mt-4 text-center text-sm text-muted-foreground">
                Don't have an account?
                <TextLink :href="route('register')" class="ml-1 font-medium text-primary hover:underline" :tabindex="6">Create an account</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
