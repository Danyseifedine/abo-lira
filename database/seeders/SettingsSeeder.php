<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Email Settings
            [
                'key' => 'mail_mailer',
                'value' => 'smtp',
                'group' => 'email',
                'hint' => 'The mailer driver that will be used to send emails (e.g. smtp, sendmail, etc.)',
            ],
            [
                'key' => 'mail_host',
                'value' => 'smtp.gmail.com',
                'group' => 'email',
                'hint' => 'SMTP mail server host',
            ],
            [
                'key' => 'mail_port',
                'value' => '587',
                'group' => 'email',
                'hint' => 'SMTP mail server port',
            ],
            [
                'key' => 'mail_username',
                'value' => 'danysmo123@gmail.com',
                'group' => 'email',
                'hint' => 'SMTP username for email sending',
            ],
            [
                'key' => 'mail_password',
                'value' => 'oxagzndbcwilnnvh',
                'group' => 'email',
                'hint' => 'SMTP password for email sending',
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'group' => 'email',
                'hint' => 'Encryption type for email (tls, ssl, or null for none)',
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'lebify@gmail.com',
                'group' => 'email',
                'hint' => 'The default email address that will appear as the sender',
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'LEBIFY',
                'group' => 'email',
                'hint' => 'The name that will be used as the sender in outgoing emails',
            ],
            [
                'key' => 'must_verify_email_on_registration',
                'value' => 'true',
                'group' => 'email',
                'hint' => 'If enabled, new users must verify their email address to activate their account',
            ],

            // Appearance
            [
                'key' => 'items_per_page',
                'value' => '25',
                'group' => 'appearance',
                'hint' => 'Default items per page in tables',
            ],
            [
                'key' => 'timezone',
                'value' => 'UTC',
                'group' => 'appearance',
                'hint' => 'Application timezone',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
