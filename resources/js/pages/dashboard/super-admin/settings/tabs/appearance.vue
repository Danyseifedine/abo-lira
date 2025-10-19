<script setup lang="ts">
import DashboardSelect from '@/common/components/dashboards/form/DashboardSelect.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Palette } from 'lucide-vue-next';

interface Setting {
    id: number;
    key: string;
    value: string;
    hint: string;
}

interface Props {
    settings: Setting[];
    formSettings: Record<string, string>;
}

defineProps<Props>();

const emit = defineEmits<{
    'update:setting': [key: string, value: string];
}>();

// Items per page options
const itemsPerPageOptions = [
    { name: '10 items', code: '10' },
    { name: '25 items', code: '25' },
    { name: '50 items', code: '50' },
    { name: '100 items', code: '100' },
];

// Timezone options (common timezones)
const timezoneOptions = [
    { name: 'UTC', code: 'UTC' },
    { name: 'America/New_York (EST)', code: 'America/New_York' },
    { name: 'America/Chicago (CST)', code: 'America/Chicago' },
    { name: 'America/Denver (MST)', code: 'America/Denver' },
    { name: 'America/Los_Angeles (PST)', code: 'America/Los_Angeles' },
    { name: 'Europe/London', code: 'Europe/London' },
    { name: 'Europe/Paris', code: 'Europe/Paris' },
    { name: 'Europe/Berlin', code: 'Europe/Berlin' },
    { name: 'Asia/Dubai', code: 'Asia/Dubai' },
    { name: 'Asia/Tokyo', code: 'Asia/Tokyo' },
    { name: 'Asia/Shanghai', code: 'Asia/Shanghai' },
    { name: 'Australia/Sydney', code: 'Australia/Sydney' },
];

const updateSetting = (key: string, value: string) => {
    emit('update:setting', key, value);
};
</script>

<template>
    <Card>
        <CardHeader>
            <div class="flex items-center gap-3">
                <Palette class="h-5 w-5 text-primary" />
                <div>
                    <CardTitle>Appearance Settings</CardTitle>
                    <CardDescription class="mt-1"> Configure visual preferences and display settings </CardDescription>
                </div>
            </div>
        </CardHeader>
        <CardContent>
            <div class="space-y-6">
                <!-- Items Per Page -->
                <div class="space-y-2">
                    <label class="text-sm font-medium">Items Per Page</label>
                    <DashboardSelect
                        :model-value="formSettings.items_per_page"
                        :options="itemsPerPageOptions"
                        option-label="name"
                        option-value="code"
                        placeholder="Select items per page"
                        :show-clear="false"
                        @update:model-value="(value) => updateSetting('items_per_page', value as string)"
                    />
                    <p class="text-xs text-muted-foreground">Default number of items to display per page in tables</p>
                </div>

                <!-- Timezone -->
                <div class="space-y-2">
                    <label class="text-sm font-medium">Application Timezone</label>
                    <DashboardSelect
                        :model-value="formSettings.timezone"
                        :options="timezoneOptions"
                        option-label="name"
                        option-value="code"
                        placeholder="Select timezone"
                        :show-clear="false"
                        filter
                        filter-placeholder="Search timezones..."
                        @update:model-value="(value) => updateSetting('timezone', value as string)"
                    />
                    <p class="text-xs text-muted-foreground">The default timezone for displaying dates and times</p>
                </div>
            </div>
        </CardContent>
    </Card>
</template>
