<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lands;
use App\Models\Lookups;
use App\Models\Projects;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    //
    public function index(){
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('admin.Projects.list',$data);
    }
    public function add($land_id = null){

        $data['lands'] = Lands::all()->filter(function($land) {
            return $land->isValuationApproved() && $land->isLegalApproved();
        });
        $data['land_id'] = $land_id ;

        return view('admin.Projects.addProject',$data);
    }
    public function store(Request $request){
        try {
            // Validate the request data
            $validated = $request->validate([
                'land_id' => 'required',
                'title' => 'required',
                'project_cost' => 'required',
                'project_type_cd' => 'required',
                'area' => 'required',
            ]);
            $project = new Projects();
            $project->land_id = $request->land_id;
            $project->title = $request->title;
            $project->project_type_cd = $request->project_type_cd;
            $project->setStatus('new');
            $project->setEvaluationStatus('pending');
            $project->setProjectStatus('pending');
            $project->setAwardedStatus('pending');
            $project->area = $request->area;
            $project->project_cost = $request->project_cost;
            $project->offers_start_date = $request->offers_start_date;
            $project->offers_end_date = $request->offers_end_date;
            $project->creator_id = auth()->user()->id;
            $project->save();

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Project added successfully'),
                'redirect' => route('projects.index')
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
        $data['project'] = Projects::find($id);
        $data['land'] = $data['project']->lands;
        return view('admin.Projects.viewProject',$data);

    }
    public function edit($id){
        $data['project'] = Projects::find($id);
        $data['lands'] = Lands::query()->where('valuation_status_cd',22)->where('legal_status_cd',25)->get();

        return view('admin.Projects.editProject',$data);
    }
    public function update(Request $request,$id){
        try {
            // Validate the request data
            $validated = $request->validate([
                'land_id' => 'required',
                'title' => 'required',
                'project_cost' => 'required',
                'project_type_cd' => 'required',
                'area' => 'required',
            ]);
            $data['project'] = Projects::find($id);
            $data['project']->land_id = $request->land_id;
            $data['project']->title = $request->title;
            $data['project']->project_type_cd = $request->project_type_cd;
            $data['project']->setStatus('new');
            $data['project']->setEvaluationStatus('pending');
            $data['project']->setProjectStatus('pending');
            $data['project']->setAwardedStatus('pending');
            $data['project']->area = $request->area;
            $data['project']->project_cost = $request->project_cost;
            $data['project']->offers_start_date = $request->offers_start_date;
            $data['project']->offers_end_date = $request->offers_end_date;
            $data['project']->creator_id = auth()->user()->id;
            $data['project']->save();

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Project added successfully'),
                'redirect' => route('projects.index')
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

    public function engineering_consultant_evaluation(Request $request ,$id){
        $data['project'] = Projects::find($id);
        $data['land'] = $data['project']->lands;
        return view('admin.Projects.project_evaluation_by_engineering_consultant',$data);
    }
    public function getProjects(Request $request){
        $projects = Projects::query()->orderBy('id', 'desc');

        if ($request->filled('project_type_cd')) {
            $projects->where('project_type_cd', 'like', '%' . $request->project_type_cd . '%');
        }
        return DataTables::of($projects)
            ->addColumn('title', function ($projects) {
                return '<div class="badge badge-light fw-bold">' . $projects->title . '</div>';
            })
            ->rawColumns(['title']) // Make sure to render the HTML as-is
            ->filterColumn('title', function ($query, $keyword) {
                $query->where('title', 'like', "%{$keyword}%");
            })
            ->addColumn('project_type_cd', function ($projects) {
                return '<div class="badge badge-light fw-bold">' . getlookup($projects->project_type_cd)->{'name_'. app()->getLocale()} . '</div>';
            })
            ->addColumn('project_status_cd', function ($projects) {
                return '<div class="badge badge-light-' . $projects->statusLookup?->extra_1 . '"> <i class="la la-' . $projects->statusLookup?->extra_2 . ' text-' . $projects->statusLookup?->extra_1 . ' fw-bold ">' . getlookup($projects->project_status_cd)->{'name_'. app()->getLocale()} . '</div>';
            })
            ->addColumn('engineering_consultant_evaluation_status_cd', function ($projects) {
                return '<div class="badge badge-light-' . $projects->statusLookup?->extra_1 . '"> <i class="la la-' . $projects->statusLookup?->extra_2 . ' text-' . $projects->statusLookup?->extra_1 . ' fw-bold">' . getlookup($projects->engineering_consultant_evaluation_status_cd)->{'name_' . app()->getLocale()} ?? '-' .
                    '</div>';
            })

            ->addColumn('approval_status_cd', function ($projects) {
                return '<div class="badge badge-light-' . $projects->statusLookup?->extra_1 . '"> <i class="la la-' . $projects->statusLookup?->extra_2 . ' text-' . $projects->statusLookup?->extra_1 . ' fw-bold">' . getlookup($projects->approval_status_cd)->{'name_' . app()->getLocale()} ?? '-' . '</div>';
            })
            ->addColumn('awarded_engineering_creator_approval_cd', function ($projects) {
                return '<div class="badge badge-light-' . $projects->statusLookup?->extra_1 . '"> <i class="la la-' . $projects->statusLookup?->extra_2 . ' text-' . $projects->statusLookup?->extra_1 . ' fw-bold">' . getlookup($projects->awarded_engineering_creator_approval_cd)->{'name_' . app()->getLocale()} ?? '-' . '</div>';
            })
            ->addColumn('offers_start_date', function ($projects) {
                return '<div class="badge badge-light fw-bold">' . $projects->offers_start_date . '</div>';
            })
            ->addColumn('offers_end_date', function ($projects) {
                return '<div class="badge badge-light fw-bold">' . $projects->offers_end_date . '</div>';
            })
            ->addColumn('actions', function ($projects) {
                $actions = '<div class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';
                if (auth()->user()->can('Projects view')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/projects/view-project/{$projects->id}") . '" class="menu-link px-3">'
                        . trans('admin.View') . '</a>
                             </div>';
                }
                if (auth()->user()->can('Projects edit')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/projects/edit-project/{$projects->id}") . '" class="menu-link px-3">'
                        . trans('admin.Edit') . '</a>
                             </div>';
                }
                if (auth()->user()->can('Engineering Consultant Evaluation')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/projects/engineering-consultant-evaluation/{$projects->id}") . '" class="menu-link px-3 text-start">'
                        . trans('admin.Engineering Consultant Evaluation') . '</a>
                             </div>';
                }

                $actions .= '<div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-lands-table-filter="delete_row" data-land-id="' . $projects->id . '">'
                    . trans('admin.Delete') . '</a>
                             </div>';


                $actions .= '</div></div>';

                return $actions;
            })
            ->rawColumns(['title','project_type_cd','project_status_cd','engineering_consultant_evaluation_status_cd','approval_status_cd','awarded_engineering_creator_approval_cd','offers_start_date','offers_end_date', 'actions'])
            ->make(true);

    }
}
