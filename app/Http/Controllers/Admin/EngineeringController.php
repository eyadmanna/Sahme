<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EngineeringPartner;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class EngineeringController extends Controller
{
    public function index(){

        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('admin.engineering_partner_management.list',compact('data'));
    }
    public function create(){

        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('admin.engineering_partner_management.create',compact('data'));
    }
    public function get_engineering_partners(Request $request)
    {
        $users = EngineeringPartner::query()->orderBy('id', 'desc');

        if ($request->filled('mobile')) {
            $users->where('mobile', 'like', '%' . $request->mobile . '%');
        }


        return DataTables::of($users)
            ->addColumn('company_name', function ($user) {
                $imgUrl = asset('assets/media/avatars/300-6.jpg'); // Or use $user->image if dynamic
                $profileUrl = route('engineering_partners.profile',$user->id); // Proper Profile link
                $avatar = $user->logo ? asset('uploads/logos/' . $user->logo) : $imgUrl;

                return '
        <div class="d-flex align-items-center">
            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                <a href="'.$profileUrl.'">
                    <div class="symbol-label">
                        <img src="'.$avatar.'" alt="'.e($user->company_name).'" class="w-100">
                    </div>
                </a>
            </div>
            <div class="d-flex flex-column">
                <a href="'.$profileUrl.'" class="text-gray-800 text-hover-primary mb-1 user-name">'.$user->company_name.'</a>
                <span class="text-muted">'.$user->email.'</span>
            </div>
        </div>
    ';
            })
            ->filterColumn('company_name', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('company_name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('mobile', function ($user) {
                return '<span>'.$user->mobile.'</span>';
            })

            ->addColumn('status_cd', function ($user) {
                $locale = app()->getLocale();
                $status = $user->statusLookup?->{'name_' . $locale} ?? '-';
                $extra_1 = $user->statusLookup?->extra_1; // اللون
                $extra_2 = $user->statusLookup?->extra_2; // اسم الأيقونة (مثل ki-check)

                return '<span class="badge badge-light-'.$extra_1.'">
                            <i class="la la-' . e($extra_2) . ' text-info"></i>
                             '.$status.'
                            </span>';
            })

            ->addColumn('created_at', function ($user) {
                $date = $user->created_at ? $user->created_at->format('Y-m-d') : '-';
                return '<div class="badge badge-light fw-bold">' . $date . '</div>';
            })
            ->addColumn('actions', function ($user) {
                $actions = '<div class="text-end">
                            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                if (auth()->user()->can('user view')) {
                    $actions .= '<div class="menu-item px-3">
                                                        <a href="' .route('engineering_partners.profile',$user->id). '" class="menu-link px-3">'
                        . trans('admin.View User') .
                        '</a>
                                                     </div>';
                }

                 $actions .= '</div></div>';

                return $actions;
            })
            ->rawColumns(['company_name','status_cd','mobile','created_at','actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'province_cd' => 'required',
            'city_cd' => 'required',
            'district_cd' => 'required',
            'address' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'commercial_registration_number' => 'required|string|max:255',
            'specializations' => 'required|string|max:255',
            'tax_number' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'logo' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'company_profile' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'commercial_registration' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'liecence' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'tax_record' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'previous_projects' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'password' => 'required|string|min:8|confirmed',
        ]);
        try {
            $uploadFields = [
                'logo' => 'logo',
                'company_profile' => 'company',
                'commercial_registration' => 'commercial',
                'liecence' => 'liecence',
                'tax_record' => 'tax',
                'previous_projects' => 'projects',
            ];

            $paths = [];

            foreach ($uploadFields as $field => $prefix) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $prefix . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path("uploads/{$field}"), $fileName);
                    $paths[$field] = "uploads/{$field}/" . $fileName;
                }
            }

             EngineeringPartner::create([
                'company_name' => $request->company_name,
                'mobile' => $request->mobile,
                'province_cd' => $request->province_cd,
                'city_cd' => $request->city_cd,
                'district_cd' => $request->district_cd,
                'address' => $request->address,
                'experience_years' => $request->experience_years,
                'commercial_registration_number' => $request->commercial_registration_number,
                'specializations' => $request->specializations,
                'tax_number' => $request->tax_number,
                'email' => $request->email,
                'logo' => $paths['logo'] ?? null,
                'company_profile' => $paths['company_profile'] ?? null,
                'commercial_registration' => $paths['commercial_registration'] ?? null,
                'liecence' => $paths['liecence'] ?? null,
                'tax_record' => $paths['tax_record'] ?? null,
                'previous_projects' => $paths['previous_projects'] ?? null,
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'success' => true,
                'message' => __('engineering.profile_updated_successfully')
            ]);
        }
        catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('engineering.error_occurred')
            ], 500);
        }

    }
    public function profile($id)
    {
        $user=EngineeringPartner::query()->findOrFail($id);
        return view('admin.engineering_partner_management.profile.index',compact('user'));
    }
    public function profile_settings($id)
    {
        $user=EngineeringPartner::query()->findOrFail($id);
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('admin.engineering_partner_management.profile.settings',compact('user','data'));
    }
    public function update_settings(Request $request,$id)
    {
        $user=EngineeringPartner::query()->findOrFail($id);

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'province_cd' => 'required|integer|exists:lookups,id',
            'city_cd' => 'required|integer|exists:lookups,id',
            'district_cd' => 'required|integer|exists:lookups,id',
            'address' => 'required|string|max:500',
            'experience_years' => 'required|integer|min:0',
            'commercial_registration_number' => 'required|string|max:100',
            'specializations' => 'required|string|max:255',
            'tax_number' => 'required|string|max:100',

            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'company_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'commercial_registration' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'liecence' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tax_record' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'previous_projects' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $uploadFields = [
                'logo' => 'logo',
                'company_profile' => 'company',
                'commercial_registration' => 'commercial',
                'liecence' => 'liecence',
                'tax_record' => 'tax',
                'previous_projects' => 'projects',
            ];

            $paths = [];

            foreach ($uploadFields as $field => $prefix) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $prefix . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path("uploads/{$field}"), $fileName);
                    $paths[$field] = "uploads/{$field}/" . $fileName;
                }
            }


            $user->company_name = $validated['company_name'];
            $user->mobile = $validated['mobile'];
            $user->province_cd = $validated['province_cd'];
            $user->city_cd = $validated['city_cd'];
            $user->district_cd = $validated['district_cd'];
            $user->address = $validated['address'];
            $user->experience_years = $validated['experience_years'];
            $user->commercial_registration_number = $validated['commercial_registration_number'];
            $user->specializations = $validated['specializations'];
            $user->tax_number = $validated['tax_number'];

            if (isset($paths['logo'])) {
                $user->logo = $paths['logo'];
            }
            if (isset($paths['company_profile'])) {
                $user->company_profile = $paths['company_profile'];
            }
            if (isset($paths['commercial_registration'])) {
                $user->commercial_registration = $paths['commercial_registration'];
            }
            if (isset($paths['liecence'])) {
                $user->liecence = $paths['liecence'];
            }
            if (isset($paths['tax_record'])) {
                $user->tax_record = $paths['tax_record'];
            }
            if (isset($paths['previous_projects'])) {
                $user->previous_projects = $paths['previous_projects'];
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => __('engineering.profile_updated_successfully')
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('engineering.error_occurred')
            ], 500);
        }
    }

    public function update_password(Request $request,$id)
    {
        $request->validate([
            'currentpassword' => ['required'],
            'newpassword' => ['required', 'string', 'min:8'],
            'confirmpassword' => ['required', 'same:newpassword'],
        ], [
            'currentpassword.required' => __('engineering.current_password_required'),
            'newpassword.required' => __('engineering.new_password_required'),
            'newpassword.min' => __('engineering.password_min_length'),
            'confirmpassword.required' => __('engineering.confirm_password_required'),
            'confirmpassword.same' => __('engineering.passwords_do_not_match'),
        ]);

        $user=EngineeringPartner::query()->findOrFail($id);

        if (!Hash::check($request->currentpassword, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('engineering.current_password_incorrect'),
            ], 422);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => __('engineering.password_updated_successfully'),
        ]);
    }
    public function accredit($id)
    {
        $user = EngineeringPartner::findOrFail($id);

        try {
            $user->markAsApproved()->save();

            return response()->json([
                'success' => true,
                'message' => __('engineering.accreditation_success')
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'message' => __('engineering.error_occurred')
            ], 500);
        }
    }
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $partner = EngineeringPartner::findOrFail($id);
        $partner->markAsRejected();
        $partner->rejection_reason = $request->reason;
        $partner->save();

        return response()->json([
            'success' => true,
            'message' => __('engineering.rejection_success')
        ]);
    }





}
