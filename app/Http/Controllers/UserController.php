<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $users = User::where('name', 'like', "%$filter%")
            ->orWhere('email', 'like', "%$filter%")
            ->paginate(10);

        return view('user.user_manage', compact('users'));
    }

    public function update($id, $column_name, $value)
    {
        DB::table('users')
            ->where('id', $id)
            ->update([$column_name => $value]);
        return $this->index();
    }


}
