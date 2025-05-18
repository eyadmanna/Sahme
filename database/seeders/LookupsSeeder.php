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
                'master_key' => 'province',
                'name_ar' => 'المحافظات',
                'name_en' => 'Provinces',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'city',
                'name_ar' => 'المدن',
                'name_en' => 'Cities',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'area',
                'name_ar' => 'الأحياء',
                'name_en' => 'Areas',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 1,
                'master_key' => 'province',
                'name_ar' => 'قطاع غزة',
                'name_en' => 'Gaza Strip',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 1,
                'master_key' => 'province',
                'name_ar' => 'الضفة الغربية',
                'name_en' => 'West Bank',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                'master_key' => 'city',
                'name_ar' => 'مدينة غزة',
                'name_en' => 'Gaza City',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                'master_key' => 'city',
                'name_ar' => 'خانيونس',
                'name_en' => 'Khanyounes',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 4,
                'master_key' => 'city',
                'name_ar' => 'رفح',
                'name_en' => 'Rafah',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 6,
                'master_key' => 'area',
                'name_ar' => 'غزة',
                'name_en' => 'Gaza',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 6,
                'master_key' => 'area',
                'name_ar' => 'مخيم الشاطئ',
                'name_en' => 'Shati Camp',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 7,
                'master_key' => 'area',
                'name_ar' => 'بني سهيلة',
                'name_en' => 'Bani Suhayla',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 7,
                'master_key' => 'area',
                'name_ar' => 'عبسان',
                'name_en' => 'Abasan',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 8,
                'master_key' => 'area',
                'name_ar' => 'الشابورة',
                'name_en' => 'Shabourah',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 8,
                'master_key' => 'area',
                'name_ar' => 'حي السلام',
                'name_en' => 'Al Salam',
            ],
            [
                'is_managed' => 0,
                'parent_id' => 0,
                'master_key' => 'engineering_partner_status',
                'name_ar' => 'حالة الشريك الهندسي',
                'name_en' => 'Engineering Partner Status',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'engineering_partner_status',
                'item_key' => 'pending',
                'name_ar' => 'بانتظار الاعتماد',
                'name_en' => 'Pending',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'engineering_partner_status',
                'item_key' => 'approved',
                'name_ar' => 'معتمد',
                'name_en' => 'Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'engineering_partner_status',
                'item_key' => 'rejected',
                'name_ar' => 'مرفوض',
                'name_en' => 'Rejected',
                'extra_1' => 'danger',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'ownership_type_cd',
                'name_ar' => 'نوع الملكية',
                'name_en' => 'Ownership Type',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 19,
                'master_key' => 'ownership_type_cd',
                'name_ar' => 'طابو',
                'name_en' => 'Taboo',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'valuation_status_cd',
                'item_key' => 'pending',
                'name_ar' => 'بانتظار الاعتماد',
                'name_en' => 'Pending',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'valuation_status_cd',
                'item_key' => 'approved',
                'name_ar' => 'معتمد',
                'name_en' => 'Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'valuation_status_cd',
                'item_key' => 'edit_request',
                'name_ar' => 'طلب تعديل السعر',
                'name_en' => 'Price Adjustment Request',
                'extra_1' => 'warning',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'legal_status_cd',
                'item_key' => 'pending',
                'name_ar' => 'بانتظار الاعتماد',
                'name_en' => 'Pending',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'legal_status_cd',
                'item_key' => 'approved',
                'name_ar' => 'معتمد',
                'name_en' => 'Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'legal_status_cd',
                'item_key' => 'rejected',
                'name_ar' => 'مرفوض',
                'name_en' => 'Rejected',
                'extra_1' => 'danger',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'engineering_consultant_evaluation_status_cd',
                'item_key' => 'pending',
                'name_ar' => 'بانتظار التقييم',
                'name_en' => 'Pending',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'engineering_consultant_evaluation_status_cd',
                'item_key' => 'need_edit',
                'name_ar' => 'يحتاج تعديل',
                'name_en' => 'Needs Editing',
                'extra_1' => 'warning',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'engineering_consultant_evaluation_status_cd',
                'item_key' => 'no_need_edit',
                'name_ar' => 'لا يحتاج تعديل',
                'name_en' => 'No Need Editing',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_approval_status_cd',
                'item_key' => 'pending',
                'name_ar' => 'بانتظار الاعتماد',
                'name_en' => 'Pending',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_approval_status_cd',
                'item_key' => 'approved',
                'name_ar' => 'معتمد',
                'name_en' => 'Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_approval_status_cd',
                'item_key' => 'rejected',
                'name_ar' => 'مرفوض',
                'name_en' => 'Rejected',
                'extra_1' => 'danger',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'awarded_engineering_creator_approval_cd',
                'item_key' => 'pending',
                'name_ar' => 'بانتظار الاعتماد',
                'name_en' => 'Pending',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'awarded_engineering_creator_approval_cd',
                'item_key' => 'approved',
                'name_ar' => 'معتمد',
                'name_en' => 'Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'awarded_engineering_creator_approval_cd',
                'item_key' => 'rejected',
                'name_ar' => 'مرفوض',
                'name_en' => 'Rejected',
                'extra_1' => 'danger',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_status_cd',
                'item_key' => 'new',
                'name_ar' => 'جديد',
                'name_en' => 'New',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_status_cd',
                'item_key' => 'approved',
                'name_ar' => 'معتمد',
                'name_en' => 'Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_status_cd',
                'item_key' => 'rejected',
                'name_ar' => 'مرفوض',
                'name_en' => 'Rejected',
                'extra_1' => 'danger',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_status_cd',
                'item_key' => 'accepting_offers',
                'name_ar' => 'استقبال عروض الأسعار',
                'name_en' => 'Accepting Offers',
                'extra_1' => 'primary',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_status_cd',
                'item_key' => 'waiting_for_awarding',
                'name_ar' => 'بانتظار الترسية',
                'name_en' => 'Awaiting Award Decision',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_status_cd',
                'item_key' => 'awarded',
                'name_ar' => 'تم الترسية',
                'name_en' => 'Awarded',
                'extra_1' => 'primary',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'project_status_cd',
                'item_key' => 'awarding_approved',
                'name_ar' => 'تم اعتماد الترسية',
                'name_en' => 'Award Decision Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 0,
                'master_key' => 'land_attachment_types',
                'name_ar' => 'نوع مرفقات الأرض',
                'name_en' => 'Land Attachment Types',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 43,
                'master_key' => 'land_attachment_types',
                'item_key' => 'land_creation_attachments',
                'name_ar' => 'مرفقات إضافة الأرض',
                'name_en' => 'Land Creation Attachments',
            ],
            [
                'is_managed' => 1,
                'parent_id' => 43,
                'master_key' => 'land_attachment_types',
                'item_key' => 'land_ownership_attachments',
                'name_ar' => 'مرفقات ملكية الأرض',
                'name_en' => 'Land Ownership Attachments',
            ],
            [
                'is_managed' => 0,
                'parent_id' => 0,
                'master_key' => 'investor_status',
                'name_ar' => 'حالة المستثمر',
                'name_en' => 'Investor Status',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'investor_status',
                'item_key' => 'pending',
                'name_ar' => 'بانتظار الاعتماد',
                'name_en' => 'Pending',
                'extra_1' => 'info',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'investor_status',
                'item_key' => 'approved',
                'name_ar' => 'معتمد',
                'name_en' => 'Approved',
                'extra_1' => 'success',
            ],
            [
                'is_managed' => 0,
                'master_key' => 'investor_status',
                'item_key' => 'rejected',
                'name_ar' => 'مرفوض',
                'name_en' => 'Rejected',
                'extra_1' => 'danger',
            ],





        ];

        foreach ($lookups as $lookup) {
            Lookups::firstOrCreate(
                $lookup
            );
        }

    }
}
