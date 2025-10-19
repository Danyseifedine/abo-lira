<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import { useToast } from '@/core/composables/useToast';
import { type BreadcrumbItem } from '@core/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Mail, Palette, Settings } from 'lucide-vue-next';
import Tab from 'primevue/tab';
import TabList from 'primevue/tablist';
import TabPanel from 'primevue/tabpanel';
import TabPanels from 'primevue/tabpanels';
import Tabs from 'primevue/tabs';
import { computed, onMounted, ref } from 'vue';
import AppearanceTab from './tabs/appearance.vue';
import EmailTab from './tabs/email.vue';

interface Setting {
    id: number;
    key: string;
    value: string;
    hint: string;
}

interface SettingsGroups {
    [group: string]: Setting[];
}

const props = defineProps<{
    settings: SettingsGroups;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('super-admin.dashboard'),
    },
    {
        title: 'Settings',
        href: route('super-admin.settings.index'),
    },
];

// Group configuration with icons and descriptions
const groupConfig = {
    email: {
        icon: Mail,
        title: 'Email',
        description: 'Email configuration and sender details',
    },
    appearance: {
        icon: Palette,
        title: 'Appearance',
        description: 'Visual preferences and display settings',
    },
};

// Transform settings to form data
const formData = computed(() => {
    const data: Record<string, string> = {};
    Object.values(props.settings).forEach((group) => {
        group.forEach((setting) => {
            data[setting.key] = setting.value;
        });
    });
    return data;
});

const form = useForm({
    settings: formData.value,
});

const activeTab = ref(0);

const handleSubmit = () => {
    form.post(route('super-admin.settings.update'), {
        preserveScroll: true,
    });
};

// Handle setting update from tab components
const updateSetting = (key: string, value: string) => {
    form.settings[key] = value;
};

const { initFlashToasts } = useToast();

onMounted(() => {
    initFlashToasts();
});
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head title="Settings" />

        <div class="p-4">
            <div class="mb-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                        <Settings class="h-6 w-6 text-primary" />
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Application Settings</h1>
                        <p class="mt-1 text-muted-foreground">Manage your application configuration and preferences</p>
                    </div>
                </div>
            </div>

            <form @submit.prevent="handleSubmit">
                <Tabs v-model="activeTab" value="0" class="space-y-6">
                    <TabList class="mb-6">
                        <Tab v-for="(config, index) in Object.values(groupConfig)" :key="index" :value="index" class="flex items-center gap-2">
                            <component :is="config.icon" class="h-4 w-4" />
                            <span class="hidden sm:inline">{{ config.title }}</span>
                        </Tab>
                    </TabList>

                    <TabPanels>
                        <!-- Email Tab -->
                        <TabPanel :value="0">
                            <EmailTab
                                v-if="settings.email"
                                :settings="settings.email"
                                :form-settings="form.settings"
                                @update:setting="updateSetting"
                            />
                        </TabPanel>

                        <!-- Appearance Tab -->
                        <TabPanel :value="1">
                            <AppearanceTab
                                v-if="settings.appearance"
                                :settings="settings.appearance"
                                :form-settings="form.settings"
                                @update:setting="updateSetting"
                            />
                        </TabPanel>
                    </TabPanels>
                </Tabs>

                <div class="mt-6 flex items-center justify-end gap-3 rounded-lg border bg-card p-4">
                    <DashboardButton
                        type="button"
                        variant="ghost"
                        @click="() => router.visit(route('super-admin.settings.index'), { preserveScroll: true })"
                    >
                        Reset
                    </DashboardButton>
                    <DashboardButton type="submit" variant="default" :loading="form.processing" :disabled="!form.isDirty">
                        Save Changes
                    </DashboardButton>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
