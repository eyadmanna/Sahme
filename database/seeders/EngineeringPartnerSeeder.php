<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Lookups;

class EngineeringPartnerSeeder extends Seeder
{
    public function run()
    {
        $status = Lookups::where('master_key', 'engineering_partner_status')
            ->where('item_key', EngineeringPartner::STATUS_PENDING)
            ->first();

        EngineeringPartner::create([
            'company_name' => 'شركة الهندسة المتقدمة',
            'mobile' => '0599999999',
            'province_cd' => 4,
            'city_cd' => 6,
            'district_cd' => 9,
            'address' => 'Gaza, Palestine',
            'experience_years' => 5,
            'status_cd' => $status?->id,
            'commercial_registration_number' => 'CR123456789',
            'specializations' => 'تصميم، إشراف، استشارات',
            'tax_number' => 'TX987654321',
            'email' => 'company@company.com',
            'logo' => 'uploads/logo/1747047025_logo.jpg',
            'company_profile' => 'uploads/company_profile/1747204255_company.jpg',
            'commercial_registration' => 'uploads/commercial_registration/1747204255_commercial.jpg',
            'liecence' => 'uploads/liecence/1747204255_liecence.jpg',
            'tax_record' => 'uploads/tax_record/1747204255_tax.jpg',
            'previous_projects' => 'uploads/previous_projects/1747204255_projects.jpg',
            'password' => Hash::make('company@company.com'),
        ]);
    }
}

