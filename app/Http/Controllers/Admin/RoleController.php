<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ModelHasRole;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:add roles|edit roles|delete roles');
    }

    public function index(Request $request)
    {
        $model_has_role = ModelHasRole::all();

        $role = Role::all();
        $user = User::all();
        $permission = Permission::all();
        return view('admin.role.index', [
            'roles' => $role,
            'users' => $user,
            'model_has_role' => $model_has_role
        ]);
    }

    public function addRoleUser()
    {
        $model_has_role = ModelHasRole::all();
        $roles = Role::all();
        $users = User::all();
        $permission = Permission::all();

        return view('admin.role.add_role_user', [
            'roles' => $roles,
            'users' => $users,
            'model_has_role' => $model_has_role
        ]);
    }

    public function saveAddRoleUser(Request $request)
    {
        $request->validate(
            [
                'role_id' => 'required',
                'user_id' => 'required'
            ],
            [
                'role_id.required' => "Hãy chọn role!",
                'user_id.required' => "Hãy chọn user!"
            ]
        );
        $role_id = $request->role_id;
        $user_id = $request->user_id;
        foreach ($user_id as $key => $value) {
            $user = User::where('id', $value)->first();
            $user->assignRole($request->role_id);
        }
        return redirect(route('role.index'))->with('success', "Thêm Vai trò vào Tài khoản thành công!");
    }

    public function editRoleUser($id)
    {
        $roles = Role::all();
        $model_h_r = ModelHasRole::all();
        $user = User::where('id', $id)->first();

        return view('admin.role.edit_role_user', [
            'roles' => $roles,
            'model_h_r' => $model_h_r,
            'user' => $user
        ]);
    }

    public function saveEditRoleUser($id, Request $request)
    {
        $user = User::find($id);
        $request->validate(
            [
                'role_id' => 'required'
            ],
            [
                'role_id.required' => "Hãy chọn role!"
            ]
        );
        $user->roles()->detach();
        $user->assignRole($request->role_id);
        return redirect(route('role.index'))->with('success_user', "Sửa Vai trò Tài khoản thành công!");
    }

    public function removeRoleUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back();
        }
        $model_has_roles = ModelHasRole::where('model_id', $id)->get();
        if (!empty($model_has_roles)) {
            $user->roles()->detach();
            return redirect(route('role.index'))->with('success_user', "Xóa Vai trò của Tài khoản thành công!");
        }
        return redirect(route('role.index'))->with('success_user', "Xóa Vai trò của Tài khoản thành công!");
    }

    public function addRolePermission()
    {
        $model_has_role = ModelHasRole::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $role_has_permission = RoleHasPermission::all();
        // dd($role_has_permission);
        return view('admin.role.add_role_permission', [
            'roles' => $roles,
            'permissions' => $permissions,
            'model_has_role' => $model_has_role,
            'role_has_permission' => $role_has_permission
        ]);
    }

    public function saveAddRolePermission(Request $request)
    {
        $roles = Role::all();
        $request->validate(
            [
                'name' => 'required|unique:roles',
                'permissions_id' => 'required'
            ],
            [
                'name.required' => "Hãy nhập vào tên role!",
                'name.unique' => "Tên role này đã tồn tại!",
                'permissions_id.required' => "Hãy chọn permission!"
            ]
        );
        $permissions = $request->permissions_id;

        $new_role = new Role();
        if (!$new_role) {
            return redirect()->back()->with('danger', "Error");
        }
        $new_role->name = $request->name;
        $new_role->guard_name = 'web';
        $new_role->save();
        $new_role->permissions()->attach($request->permissions_id);
        return redirect(route('role.index'))->with('success', "Tạo Vai trò mới thành công");
    }

    public function editRolePermission($id)
    {
        $role = Role::find($id);
        $role_has_permission = RoleHasPermission::where('role_id', $id)->get();
        $permissions = Permission::all();

        return view('admin.role.edit_role_permission', [
            'role' => $role,
            'role_has_permission' => $role_has_permission,
            'permissions' => $permissions
        ]);
    }

    public function saveEditRolePermission($id, Request $request)
    {
        $role = Role::find($id);
        if (!$role) {
            return redirect()->back();
        }
        $request->validate(
            [
                'name'  =>  [
                    'required', Rule::unique('roles')->ignore($id)
                ],
                // 'permissions_id' => 'required'
            ],
            [
                'name.required' => "Hãy nhập vào tên role!",
                'name.unique' => "Tên role này đã tồn tại!",
                // 'permissions_id.required' => "Hãy chọn permission!"
            ]
        );
        $permissions = $request->permissions_id;
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        $role_has_permission = RoleHasPermission::where('role_id', $id)->get();
        if (count($role_has_permission) > 0) {
            $role->permissions()->detach();
        }
        $role->permissions()->attach($request->permissions_id); //add list permissions
        return redirect(route('cache-permission'));
    }

    public function removeRole($id)
    {
        $role = Role::find($id);
        // dd($role);
        $role->permissions()->detach(); //delete all relationship in role_permission
        $role->delete();
        return redirect(route('role.index'))->with('success', "Xóa Vai trò thành công!");
    }
}