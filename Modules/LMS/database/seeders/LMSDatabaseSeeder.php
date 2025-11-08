<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;

class LMSDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(
            [
                ThemeSeeder::class,
                RoleSeeder::class,
                TopicTypeSeeder::class,
                CouponTypeSeeder::class,
                QuizTypeSeeder::class,
                EmailTemplateSeeder::class,
                NotificationTemplateSeeder::class,
                LanguageSeeder::class,
                IconProviderSeeder::class,
                CertificateSeeder::class,
                PageSeeder::class,
                PaymentSeeder::class,
                AiServiceTypeSeeder::class,
                CurrencySeeder::class,

            ]
        );
    }
}
