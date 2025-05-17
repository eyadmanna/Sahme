<?php

namespace Database\Seeders;

use App\Models\Investors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Investors::insert([
            [
                'full_name' => 'محمد',
                'phone' => '059000002',
                'mobile' => '059000002',
                'province_cd' => 4,
                'city_cd' => 6,
                'district_cd' => 10,
                'address' => 'الشجاعية',
                'yearly_income' => 5,
                'status_cd' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'اياد',
                'phone' => '56415646',
                'mobile' => '64561844654',
                'province_cd' => 4,
                'city_cd' => 6,
                'district_cd' => 10,
                'address' => 'الشجاعية',
                'yearly_income' => 5,
                'status_cd' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
