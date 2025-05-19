<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EngineeringPartner;
 use Illuminate\Http\Request;
 use Yajra\DataTables\Facades\DataTables;

class EngineeringController extends Controller
{
    public function index(){


        return view('admin.engineering_partner_management.list');
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
                $profileUrl = url('users/view/' . $user->id); // Proper Profile link
                $avatar = $user->logo ? asset('uploads/logo/' . $user->logo) : $imgUrl;

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
                                                        <a href="' . url("/users/view/{$user->id}") . '" class="menu-link px-3">'
                        . trans('admin.View User') .
                        '</a>
                                                     </div>';
                }

                if (auth()->user()->can('user delete')) {
                    $buttonText = $user->status == 1 ? trans('admin.Delete') : trans('admin.Activation');

                    $actions .= '<div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row" data-user-status="' . $user->status . '" data-user-id="' . $user->id . '">' .
                        $buttonText .
                        '</a>
                                                     </div>';
                }
                $actions .= '</div></div>';

                return $actions;
            })
            ->rawColumns(['company_name','mobile','created_at','actions'])
            ->make(true);
    }



}
