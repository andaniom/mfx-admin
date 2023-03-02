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
        $customers = Customer::select('customers.id', 'customers.user_id', 'customers.name', 'customers.phone_number',
            DB::raw('SUM(transactions.amount) as amount'))
            ->leftJoin('transactions', 'transactions.customer_id', '=', 'customers.id')
            ->where('customers.user_id', auth()->id())
            ->groupBy('customers.id')
            ->groupBy('customers.user_id')
            ->groupBy('customers.name')
            ->groupBy('customers.phone_number')
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

    public function update(Customer $customer, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone_number' => 'required',
        ]);

        $customer->update($request->only('name', 'phone_number'));

        notify()->success($customer->name . ', updated successfully.');
        return redirect()->route('customers.index')
            ->with('success', 'Setting updated successfully');
    }
}
