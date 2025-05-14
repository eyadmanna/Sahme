<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investors;
use App\Models\Lands;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class LandsController extends Controller
{

    public function index()
    {

        return view('admin.Lands.list');
    }
    public function add(){
        $data['investors'] = Investors::query()->get();
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        return view('admin.Lands.addLand',$data);

    }
    public function store(Request $request){
        try {
            // Validate the request data
            $validated = $request->validate([
                'investor_id' => 'required',
            ]);
            Lands::create($request->all());

            return response()->json([
                    'status' => 'success',
                    'message' => __('admin.Land added successfully'),
                    'redirect' => route('lands.index')
                ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e){
            // Return general error
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function view($id){
        $data['investors'] = Investors::query()->get();
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["city"] = Lookups::query()->where([
            "master_key" => "city"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["area"] = Lookups::query()->where([
            "master_key" => "area"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        $data['land'] = Lands::query()->find($id);
        return view('admin.Lands.view',$data);
    }

    public function getLands()
    {
        $lands = Lands::query()->orderBy('id', 'desc');

        return DataTables::of($lands)
            ->addColumn('investor_name', function ($land) {
                return '<div class="badge badge-light fw-bold">' . $land->investor->full_name . '</div>';
            })
            ->addColumn('province_cd', function ($land) {
                return getlookup($land->province_cd)?->{'name_' . app()->getLocale()} ?? '-';
            })
            ->addColumn('valuation_status_cd', function ($land) {
                return $land->valuation_status_cd;
            })
            ->addColumn('legal_status_cd', function ($land) {
                return $land->legal_status_cd;
            })
            ->addColumn('city_cd', function ($land) {
                return getlookup($land->city_cd)?->{'name_' . app()->getLocale()} ?? '-';
            })
            ->addColumn('actions', function ($land) {
                $actions = '<div class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/lands/view-land/{$land->id}") . '" class="menu-link px-3">'
                        . trans('admin.View') . '</a>
                             </div>';
                    $actions .= '<div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-lands-table-filter="delete_row" data-land-id="' . $land->id . '">'
                        . trans('admin.Delete') . '</a>
                             </div>';


                $actions .= '</div></div>';

                return $actions;
            })
            ->rawColumns(['investor_name','valuation_status_cd','legal_status_cd', 'actions'])
            ->make(true);
    }
}
