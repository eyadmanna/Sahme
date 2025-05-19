<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lands;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function index(){

    }
    public function add($land_id = null){

        $data['lands'] = Lands::query()->where('valuation_status_cd',22)->where('legal_status_cd',25)->get();
        $data['land_id'] = $land_id ;

        return view('admin.Projects.addProject',$data);
    }
    public function store(Request $request){
        try {
            // Validate the request data
            $validated = $request->validate([
                'title' => 'required',
                'project_cost' => 'required',
            ]);
            $project = new Projects();
            $project->land_id = $request->land_id;
            $project->title = $request->title;
            $project->project_type_cd = $request->project_type_cd;
            $project->area = $request->area;
            $project->project_cost = $request->project_cost;
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
}
