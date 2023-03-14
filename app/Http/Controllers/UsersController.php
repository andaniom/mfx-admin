<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\RegisterUserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
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
        $password = $this->generateRandomPassword(10);
        $user->password = Hash::make($password);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        Notification::send($user, new RegisterUserNotification($password));


        notify()->success($request->name . ', User created successfully.');

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
        $customers = Customer::select('customers.id', 'customers.user_id', 'customers.name', 'customers.phone_number',
            DB::raw('SUM(transactions.amount) as amount'))
            ->leftJoin('transactions', 'transactions.customer_id', '=', 'customers.id')
            ->where('customers.user_id', $user->id)
            ->groupBy('customers.id')
            ->groupBy('customers.user_id')
            ->groupBy('customers.name')
            ->groupBy('customers.phone_number')
            ->paginate(5);

        $totalAmountMonth = Transaction::select(DB::raw('SUM(amount) as total_amount'))
            ->where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('user_id')->first();

        $setting = Setting::where("name", 'reward')->first();;
        $reward = $setting != null ? $setting->value : '0';

        $reward = $totalAmountMonth ? $totalAmountMonth->total_amount * ($reward / 100) : 0;

        return view('users.show', compact('user', 'customers', 'reward'));
    }

    public function showProfile(User $user)
    {
        return view('profiles.show', [
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

    public function editProfile(User $user)
    {
        return view('profiles.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    public function update(User $user, Request $request)
    {
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->birth_date = $request->birth_date;
        $user->save();

        $user->syncRoles([$request->get('role')]);

        $role = Role::findById($request->get('role'));
        $user->syncPermissions($role->permissions);

        notify()->success('User updated successfully.');
        return redirect()->route('users.index');
    }

    public function updateProfile(User $user, UpdateUserRequest $request)
    {
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->birth_date = $request->birth_date;
        $user->save();

        notify()->success('User updated successfully.');
        return redirect()->route('profile.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    function generateRandomPassword($length = 10)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
        $charCount = strlen($chars);
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $randChar = $chars[rand(0, $charCount - 1)];
            $password .= $randChar;
        }
        return $password;
    }

    public function showChangePasswordForm()
    {
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        auth()->logout();


        return redirect()->route('login')->with('success', 'Your password has been changed successfully.');
    }
    public function list()
    {
        $users = User::all();
        return response()->json($users);
    }


}
