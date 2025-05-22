<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = Settings::Create(
            [
                'company_name_ar' => 'سهمي',
                'company_name_en' => 'Sahme',
                'country' => 'Palestine',
                'currency_name' => 'USD',
                'currency_symbol' => '$',
            ]
        );
    }
}
