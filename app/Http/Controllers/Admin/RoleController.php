<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['roles'] = Role::with('permissions','users')->get();
        $data['permissions'] = Permission::all();
        $data['groupedPermissions'] = \Spatie\Permission\Models\Permission::all()->groupBy('group');
        return view('admin.UserManagement.roles.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'role_name' => 'required|unique:roles,name',
                'permissions' => 'required|array'
            ]);

            $role = Role::create(['name' => $request->role_name]);
            $role->givePermissionTo($request->permissions);

            // Return JSON success response
            return response()->json([
                'message' => 'Role created successfully!',
                'user' => $role
            ], 201);
        }catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        }
        catch (\Exception $e){
            // Return general error
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {
        //
        $role = Role::with('permissions', 'users')->find($id);
        $users = $role->users;
        if ($request->ajax()) {
            return DataTables::of($users)
                ->addColumn('id', function ($user) {
                    return '<span>'.$user->id.'</span>';
                })
                ->addColumn('name', function ($user) {
                    $imgUrl = asset('assets/media/avatars/300-6.jpg'); // أو $user->image إن كنت تحفظ الصورة من قاعدة البيانات
                    $profileUrl = url('apps/user-management/users/view'); // أو يمكن ربطه بـ route()

                    return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                <a href="'.$profileUrl.'">
                    <div class="symbol-label">
                        <img src="'.$imgUrl.'" alt="'.$user->name.'" class="w-100" />
                    </div>
                </a>
            </div>
                             <div class="d-flex flex-column">
                <a href="'.$profileUrl.'" class="text-gray-800 text-hover-primary mb-1">'.$user->name.'</a>
                <span>'.$user->email.'</span>
            </div>
                        ';
                })
                ->addColumn('created_at', function ($user) {
                    $date = $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-';
                    return '<div class="badge badge-light fw-bold">' . $date . '</div>';
                })
                ->addColumn('actions', function ($user) {
                    $options = '<div class="text-end"><a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'.trans('admin.Actions') .'
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="apps/user-management/users/view.html" class="menu-link px-3">'.trans('admin.Edit').'</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">'.trans('admin.Delete').'</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div></div>
                                <!--end::Menu-->
                             ';

                    return $options;
                })
                ->rawColumns(['id','name','created_at','actions'])
                ->make(true);
        }
        return view('admin.UserManagement.Roles.view', compact('role'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //
        try {
            $request->validate([
                'role_name' => [
                    'required',
                    Rule::unique('roles', 'name')->ignore($id),
                ],
                'permissions' => 'required|array'
            ]);

            $role = Role::findOrFail($id);
            $role->name = $request->role_name;
            $role->save();
            // Sync permissions (removes old and assigns new)
            $role->syncPermissions($request->permissions);

            // Return JSON success response
            return response()->json([
                'message' => 'Role Updated successfully!',
                'user' => $role
            ], 201);
        }catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        }
        catch (\Exception $e){
            // Return general error
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
