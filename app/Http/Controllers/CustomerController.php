<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
//        $customers = Customer::where('user_id', auth()->id())->orderBy('id')->paginate(5);
        $customers = Customer::select('customers.*', DB::raw('SUM(transactions.amount) as amount'))
            ->leftJoin('transactions', 'transactions.customer_id', '=', 'customers.id')
            ->groupBy('customers.id')
            ->paginate(5);
        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone_number' => 'required',
        ]);

        $name = strtoupper($request->name);

        $customer = Customer::where('name', $name)->orWhere('phone_number', $request->phone_number)->first();
        if ($customer) {
            notify()->error($name . ', Already Exist.');
            return redirect()->back();
        }
        $customer = new Customer();
        $customer->user_id = auth()->id();
        $customer->name = $name;
        $customer->phone_number = $request->phone_number;
        $customer->save();

        if ($customer) {
            notify()->success($name . ', Setting created successfully.');
        } else {
            notify()->error($name . ', Setting created failed.');
        }
        return redirect()->back();
    }
}