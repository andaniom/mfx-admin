<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function store(Customer $customer, Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'amount' => 'required',
        ]);

        $type = $request->type;
        $amount = $request->amount;
        if ($type == "withdrawal") {
            $amount = 0 - $amount;
        }

        Log::info($customer->id);
        Log::info($request->type);
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'customer_id' => $customer->id,
            'amount' => $amount
        ]);

        return redirect()->back();
    }

    public function index(Customer $customer)
    {
        $transactions = Transaction::where('user_id', auth()->id())->where('customer_id', $customer->id)
            ->orderBy('id', 'DESC')->paginate(5);
        $totalAmount = Transaction::select(DB::raw('SUM(amount) as total_amount'))->where('user_id', auth()->id())
            ->where('customer_id', $customer->id)
            ->groupBy('user_id')->groupBy('customer_id')->first();
        $count = Transaction::where('user_id', auth()->id())
            ->where('customer_id', $customer->id)
            ->groupBy('user_id')->groupBy('customer_id')->count();
        $totalAmountMonth = Transaction::select(DB::raw('SUM(amount) as total_amount'))->where('user_id', auth()->id())
            ->where('customer_id', $customer->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('user_id')->groupBy('customer_id')->first();
        $countMonth = Transaction::where('user_id', auth()->id())
            ->where('customer_id', $customer->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('user_id')->groupBy('customer_id')->count();

        $setting = Setting::where("name", 'reward')->first();;
        $reward = $setting != null ? $setting->value : '0';

        $result = new Transaction();
        $result->transactions = $transactions;
        $result->customer = $customer;
        $result->totalAmount = $totalAmount->total_amount;
        $result->count = $count;
        $result->totalAmountMonth = $totalAmountMonth->total_amount;
        $result->countMonth = $countMonth;
        $result->reward = $totalAmount->total_amount * ($reward / 100);
        return view('transactions.index', compact('result'));
    }
}
