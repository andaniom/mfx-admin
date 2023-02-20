<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $users = User::where('name', 'like', "%$filter%")
            ->orWhere('email', 'like', "%$filter%")
            ->paginate(5);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(User $user, StoreUserRequest $request)
    {
        $user->create(array_merge($request->validated(), [
            'password' => Hash::make('123123123')
        ]));

        notify()->success($request->name.', User created successfully.');

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

//    public function update($id, $column_name, $value)
//    {
//        DB::table('users')
//            ->where('id', $id)
//            ->update([$column_name => $value]);
//        return $this->index();
//    }

    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles([$request->get('role')]);

        $role = Role::findById($request->get('role'));
        $user->syncPermissions($role->permissions);

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

}
