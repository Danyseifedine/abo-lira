<script setup lang="ts">
import DashboardMaskedInput from '@/common/components/dashboards/form/DashboardMaskedInput.vue';
import DashboardSelect from '@/common/components/dashboards/form/DashboardSelect.vue';
import DashboardInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import DashboardToggle from '@/common/components/dashboards/form/DashboardToggle.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Mail } from 'lucide-vue-next';

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

// Mailer options
const mailerOptions = [
    { name: 'SMTP', code: 'smtp' },
    { name: 'Sendmail', code: 'sendmail' },
    { name: 'Mailgun', code: 'mailgun' },
    { name: 'SES', code: 'ses' },
    { name: 'Postmark', code: 'postmark' },
];

// Encryption options
const encryptionOptions = [
    { name: 'TLS', code: 'tls' },
    { name: 'SSL', code: 'ssl' },
    { name: 'None', code: 'null' },
];

const updateSetting = (key: string, value: string) => {
    emit('update:setting', key, value);
};

const toggleBoolean = (key: string, value: boolean) => {
    emit('update:setting', key, value ? 'true' : 'false');
};
</script>

<template>
    <Card>
        <CardHeader>
            <div class="flex items-center gap-3">
                <Mail class="h-5 w-5 text-primary" />
                <div>
                    <CardTitle>Email Settings</CardTitle>
                    <CardDescription class="mt-1"> Configure your email server and sender details </CardDescription>
                </div>
            </div>
        </CardHeader>
        <CardContent>
            <div class="space-y-6">
                <!-- Mail Mailer -->
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Mail Driver</label>
                        <DashboardSelect
                            :model-value="formSettings.mail_mailer"
                            :options="mailerOptions"
                            option-label="name"
                            option-value="code"
                            filter
                            placeholder="Select mail driver"
                            :show-clear="false"
                            @update:model-value="(value) => updateSetting('mail_mailer', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">The mailer driver that will be used to send emails (e.g. smtp, sendmail, etc.)</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium">SMTP Host</label>
                        <DashboardInput
                            :model-value="formSettings.mail_host"
                            placeholder="smtp.gmail.com"
                            @update:model-value="(value) => updateSetting('mail_host', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">SMTP mail server host</p>
                    </div>
                </div>

                <!-- Mail Username -->
                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-medium">SMTP Username</label>
                        <DashboardInput
                            :model-value="formSettings.mail_username"
                            placeholder="your-email@gmail.com"
                            type="email"
                            @update:model-value="(value) => updateSetting('mail_username', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">SMTP username for email sending</p>
                    </div>

                    <!-- Mail Password -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium">SMTP Password</label>
                        <DashboardMaskedInput
                            :model-value="formSettings.mail_password"
                            placeholder="••••••••••••••••"
                            type="password"
                            toggle-mask
                            @update:model-value="(value) => updateSetting('mail_password', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">SMTP password for email sending</p>
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <!-- Mail From Name -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium">From Name</label>
                        <DashboardInput
                            :model-value="formSettings.mail_from_name"
                            placeholder="Your Application Name"
                            @update:model-value="(value) => updateSetting('mail_from_name', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">The name that will be used as the sender in outgoing emails</p>
                    </div>

                    <!-- Mail From Address -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium">From Email Address</label>
                        <DashboardInput
                            :model-value="formSettings.mail_from_address"
                            placeholder="noreply@example.com"
                            type="email"
                            @update:model-value="(value) => updateSetting('mail_from_address', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">The default email address that will appear as the sender</p>
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <!-- Mail Encryption -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Encryption Type</label>
                        <DashboardSelect
                            :model-value="formSettings.mail_encryption"
                            :options="encryptionOptions"
                            option-label="name"
                            option-value="code"
                            placeholder="Select encryption"
                            :show-clear="false"
                            @update:model-value="(value) => updateSetting('mail_encryption', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">Encryption type for email (tls, ssl, or null for none)</p>
                    </div>

                    <!-- Mail Port -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium">SMTP Port</label>
                        <DashboardInput
                            :model-value="formSettings.mail_port"
                            placeholder="587"
                            type="number"
                            @update:model-value="(value) => updateSetting('mail_port', value as string)"
                        />
                        <p class="text-xs text-muted-foreground">SMTP mail server port</p>
                    </div>
                </div>

                <!-- Must Verify Email -->
                <div class="flex items-center justify-between rounded-lg border p-4">
                    <div class="space-y-0.5">
                        <label class="text-sm font-medium">Require Email Verification</label>
                        <p class="text-sm text-muted-foreground">If enabled, new users must verify their email address to activate their account</p>
                    </div>
                    <DashboardToggle
                        :model-value="formSettings.must_verify_email_on_registration === 'true'"
                        @update:model-value="(value) => toggleBoolean('must_verify_email_on_registration', value)"
                    />
                </div>
            </div>
        </CardContent>
    </Card>
</template>
