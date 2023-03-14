<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\String\u;

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
        $user_id = auth()->id();

        return $this->getTransaction($user_id, $customer);
    }

    public function indexAdmin(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $userId = $request->user_id;

        $transactions = DB::table('transactions')
            ->leftJoin('users', 'users.id', '=', 'transactions.user_id');

        if ($start_date) {
            $transactions = $transactions->whereDate('transactions.created_at', '>=', $start_date);
        }

        if ($end_date) {
            $transactions = $transactions->whereDate('transactions.created_at', '<=', $end_date);
        }
        $transactions = $transactions->where('user_id', $userId)
            ->orderBy('transactions.id', 'DESC')->paginate(5);
        return view('transactions.admin', compact('transactions'));
    }

    public function admin(Customer $customer, User $user)
    {
        return $this->getTransaction($user->id, $customer);
    }

    /**
     * @param $user_id
     * @param Customer $customer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getTransaction($user_id, Customer $customer)
    {
        $transactions = Transaction::where('user_id', $user_id)->where('customer_id', $customer->id)
            ->orderBy('id', 'DESC')->paginate(5);
        $totalAmount = Transaction::select(DB::raw('SUM(amount) as total_amount'))->where('user_id', $user_id)
            ->where('customer_id', $customer->id)
            ->groupBy('user_id')->groupBy('customer_id')->first();
        $count = Transaction::where('user_id', $user_id)
            ->where('customer_id', $customer->id)
            ->groupBy('user_id')->groupBy('customer_id')->count();
        $totalAmountMonth = Transaction::select(DB::raw('SUM(amount) as total_amount'))->where('user_id', $user_id)
            ->where('customer_id', $customer->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('user_id')->groupBy('customer_id')->first();
        $countMonth = Transaction::where('user_id', $user_id)
            ->where('customer_id', $customer->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('user_id')->groupBy('customer_id')->count();

        $setting = Setting::where("name", 'reward')->first();;
        $reward = $setting != null ? $setting->value : '0';

        $result = new Transaction();
        $result->transactions = $transactions;
        $result->customer = $customer;
        $result->totalAmount = $totalAmount ? $totalAmount->total_amount : 0;
        $result->count = $count;
        $result->totalAmountMonth = $totalAmountMonth ? $totalAmountMonth->total_amount : 0;
        $result->countMonth = $countMonth;
        $result->reward = $totalAmount ? $totalAmount->total_amount * ($reward / 100) : 0;
        return view('transactions.index', compact('result'));
    }
}
