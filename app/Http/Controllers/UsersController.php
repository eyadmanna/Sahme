<?php

namespace App\Http\Controllers;

use App\Mail\SendLoginData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('can:Settings Section View');
        $this->middleware('can:users view');
        $this->middleware('can:user create')->only('store');
        $this->middleware('can:user view')->only('view');
        $this->middleware('can:user edit')->only('update');
    }

    public function index(){
        $users = User::paginate(10);
        $roles = Role::query()->get();

        return view('admin.UserManagement.Users.list', compact('users','roles'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'user_name' => 'required|string|max:255',
                'user_email' => 'required|email|unique:users,email',
                'mobile_number' => 'required|unique:users',
                'user_role' => 'required|exists:roles,id',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');

                $filename = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('uploads/usersImage'), $filename);
            } else {
                $filename = null;
            }
            $plainPassword = Str::random(8);

            // Create user
            $user = new User();
            $user->name = $request->user_name;
            $user->email = $request->user_email;
            $user->mobile_number = $request->mobile_number;
            $user->avatar = $filename;
            $user->password = $plainPassword;

            if (isset($request->send_login_data)){
                \Mail::to($user->email)->send(new SendLoginData($user, $plainPassword));
            }
            $user->save();


            $role = Role::find($validated['user_role']);
            $user->roles()->attach($role);

            /*$user->sendEmailVerificationNotification();*/

            // Return JSON success response
            return response()->json([
                'message' => 'User created successfully!',
                'user' => $user
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Return general error
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    public function view(Request $request , $id){
        $data['user'] = User::query()->find($id);
        $data['roles'] = Role::query()->get();

        return view('admin.UserManagement.Users.view',$data);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'user_name' => 'required|string|max:255',
                'user_email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($id),
                ],
                'mobile_number' => [
                    'required',
                    Rule::unique('users', 'mobile_number')->ignore($id),
                ],
                'user_role' => 'required|exists:roles,id',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $user = User::findOrFail($id);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/usersImage'), $filename);
                $user->avatar = $filename;
            }

            // Update user fields
            $user->name = $request->user_name;
            $user->email = $request->user_email;
            $user->mobile_number = $request->mobile_number;
            $user->save();

            // Update role
            $user->roles()->sync([$validated['user_role']]);

            return response()->json([
                'message' => 'User updated successfully!',
                'user' => $user
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        // Prevent user from deleting themselves
        if (Auth::id() == $id) {
            return response()->json([
                'success' => false,
                'message' => trans('admin.You cannot delete your own account.')
            ], 403);
        }

        $user = User::findOrFail($id);
        if ($user->status == 1)
            $user->status = 0;
        else
            $user->status = 1;

        $user->save();

        return response()->json([
            'success' => true,
            'message' =>  trans('admin.User deleted successfully.')
        ]);
    }
    public function getUsers(Request $request)
    {
        $users = User::query()->orderBy('id', 'desc');

        if ($request->filled('mobile_number')) {
            $users->where('mobile_number', 'like', '%' . $request->mobile_number . '%');
        }

        if ($request->filled('role')) {
            $users->whereHas('roles', function ($query) use ($request) {
                $query->where('id', $request->role); // or use 'name' if your select value is role name
            });
        }
        return DataTables::of($users)
            ->addColumn('name', function ($user) {
                $imgUrl = asset('assets/media/avatars/300-6.jpg'); // Or use $user->image if dynamic
                $profileUrl = url('users/view/' . $user->id); // Proper Profile link
                $avatar = $user->avatar ? asset('uploads/usersImage/' . $user->avatar) : $imgUrl;

                return '
        <div class="d-flex align-items-center">
            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                <a href="'.$profileUrl.'">
                    <div class="symbol-label">
                        <img src="'.$avatar.'" alt="'.e($user->name).'" class="w-100">
                    </div>
                </a>
            </div>
            <div class="d-flex flex-column">
                <a href="'.$profileUrl.'" class="text-gray-800 text-hover-primary mb-1 user-name">'.$user->name.'</a>
                <span class="text-muted">'.$user->email.'</span>
            </div>
        </div>
    ';
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('mobile_number', function ($user) {
                return '<span>'.$user->mobile_number.'</span>';
            })
            ->addColumn('role', function ($user) {
                return '<td>'.$user->roles->pluck('name')->join(', ') ?? '-'.'</td>';
            })
            ->addColumn('last_login_at', function ($user) {
                $date = $user->last_login ? $user->last_login->format('Y-m-d H:i') : '-';
                return '<div class="badge badge-light fw-bold">' . $date . '</div>';
            })
            ->addColumn('two_step', function ($user) {
                return $user->two_step_enabled ? 'Enabled' : 'Disabled';
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
            ->rawColumns(['name','mobile_number','role','last_login_at','created_at','two_step','actions'])
            ->make(true);
    }
}
