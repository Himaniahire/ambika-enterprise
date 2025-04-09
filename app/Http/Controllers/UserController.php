<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                0 => 'users.first_name',
                1 => 'users.last_name',
                2 => 'users.email',
                3 => 'users.username',
                4 => 'roles.name',
            ];

            $limit = $request->input('length', 10);
            $start = $request->input('start');
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderColumn = $columns[$orderColumnIndex] ?? 'users.first_name';
            $dir = $request->input('order.0.dir', 'asc'); // Default order direction
            $search = $request->input('search.value');

            $query = User::query();

            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('users.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('users.last_name', 'LIKE', "%{$search}%")
                    ->orWhere('users.email', 'LIKE', "%{$search}%")
                    ->orWhere('users.username', 'LIKE', "%{$search}%")
                    ->orWhere('users.role_id', 'LIKE', "%{$search}%");
                });
            }

            $totalData = $query->count();

            $users = $query->orderBy($orderColumn, $dir)
                        ->offset($start)
                        ->limit($limit)
                        ->get();

            $data = [];
            $i = $start + 1;

            foreach ($users as $user) {
                $data[] = [
                    'id' => $i++, // Increment row number
                    'full_name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'role_name' => $user->role->name,
                    'action' => '
                        <ul class="list-unstyled hstack gap-1 mb-0">
                            <li>
                                <a class="btn btn-sm btn-soft-danger" href="' . route('user.edit', $user->id) . '">
                                    <i data-feather="edit"></i>
                                </a>
                            </li>
                            <form action="' . route('user.destroy', $user->id) . '" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" style="border: none; background: transparent; padding: 0px">
                                    <a class="btn btn-sm btn-soft-danger"><i data-feather="trash-2"></i></a>
                                </button>
                            </form>
                        </ul>
                    ',
                ];
            }

            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $totalData,
                "recordsFiltered" => $totalData,
                "data" => $data
            ]);
        }

        return view('admin.user.index');
    }

    public function create()
    {
        $roles = Role::get();
        $permissions = Permission::get();
        return view('admin.user.add', compact('roles','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ], [
            'confirm_password.same' => 'The password confirm does not match.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Hash the password before storing it
        $hashedPassword = bcrypt($request->password);

        // Create the user and get the user instance
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $hashedPassword,
            'in_text' => $request->password,
        ]);

        // Check if permission_id is passed and store them in role_has_permissions table
        if ($request->has('permission_id')) {
            foreach ($request->permission_id as $permissionId) {
                RoleHasPermission::create([
                    'role_id' => $request->role_id,
                    'permission_id' => $permissionId,
                    'user_id' => $user->id, // Use the created user's ID
                ]);
            }
        }

        return redirect('admin/user')->with('success', 'User created successfully');
    }



    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        $permissions = Permission::get();
        $userPermissions = Permission::join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
        ->where('role_has_permissions.user_id', $user->id)  // Access user id
        ->get();
        // dd($userPermissions->permission_id);
        return view('admin.user.edit',compact('user', 'roles', 'permissions','userPermissions'));
    }

    public function update(Request $request, $id)
    {
        $hashedPassword = bcrypt($request->password);

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = $hashedPassword;
        $user->in_text = $request->password ?? $user->in_text;
        $user->update();

        // Add new permissions without deleting existing ones
        if ($request->has('permission_id')) {
            foreach ($request->permission_id as $permissionId) {
                // Check if the permission already exists for this user, if not, add it
                if (!RoleHasPermission::where('user_id', $user->id)->where('permission_id', $permissionId)->exists()) {
                    RoleHasPermission::create([
                        'role_id' => $request->role_id,
                        'permission_id' => $permissionId,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        return redirect('admin/user')->with('success', 'User Updated Successfully');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('success','User Deleted Successfully.');
    }

    public function removePermissions(Request $request)
{
    // Log incoming data for debugging
    \Log::info('Remove Permissions Request:', [
        'user_id' => $request->input('user_id'),
        'role_id' => $request->input('role_id'),
        'removed_permissions' => $request->input('removed_permissions'),
    ]);

    $user_id = $request->input('user_id');
    $role_id = $request->input('role_id');
    $removedPermissions = $request->input('removed_permissions');

    if (!empty($removedPermissions)) {
        // Log the permissions that will be removed
        \Log::info('Removing permissions from database:', [
            'user_id' => $user_id,
            'role_id' => $role_id,
            'permissions' => $removedPermissions,
        ]);

        // Delete permissions from `role_has_permissions` table
        $deleted = DB::table('role_has_permissions')
            ->where('user_id', $user_id)
            ->where('role_id', $role_id)
            ->where('permission_id', $removedPermissions)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Permissions removed successfully.']);
        } else {
            return response()->json(['error' => 'Failed to remove permissions.'], 400);
        }
    }

    return response()->json(['error' => 'No permissions to remove.'], 400);
}


}

