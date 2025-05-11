<?php

namespace Database\Seeders;

use App\Models\Lookups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LookupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $lookups = [
            [
                'is_managed' => 1,
                'parent_id' => 0,
                's_key' => 'province',
                'name_ar' => 'المحافظات',
                'name_en' => 'Provinces',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                's_key' => 'city',
                'name_ar' => 'المدن',
                'name_en' => 'Cities',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                's_key' => 'area',
                'name_ar' => 'الأحياء',
                'name_en' => 'Areas',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 1,
                's_key' => 'province',
                'name_ar' => 'قطاع غزة',
                'name_en' => 'Gaza Strip',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 1,
                's_key' => 'province',
                'name_ar' => 'الضفة الغربية',
                'name_en' => 'West Bank',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                's_key' => 'city',
                'name_ar' => 'مدينة غزة',
                'name_en' => 'Gaza City',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                's_key' => 'city',
                'name_ar' => 'خانيونس',
                'name_en' => 'Khanyounes',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                's_key' => 'city',
                'name_ar' => 'رفح',
                'name_en' => 'Rafah',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 6,
                's_key' => 'area',
                'name_ar' => 'غزة',
                'name_en' => 'Gaza',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 6,
                's_key' => 'area',
                'name_ar' => 'مخيم الشاطئ',
                'name_en' => 'Shati Camp',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 7,
                's_key' => 'area',
                'name_ar' => 'بني سهيلة',
                'name_en' => 'Bani Suhayla',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 7,
                's_key' => 'area',
                'name_ar' => 'عبسان',
                'name_en' => 'Abasan',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 8,
                's_key' => 'area',
                'name_ar' => 'الشابورة',
                'name_en' => 'Shabourah',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 8,
                's_key' => 'area',
                'name_ar' => 'حي السلام',
                'name_en' => 'Al Salam',
            ],

            
        ];

        foreach ($lookups as $lookup) {
            Lookups::firstOrCreate(
                $lookup
            );
        }

    }
}
