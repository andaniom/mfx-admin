<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Setting;
use App\Models\Task;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count = 0;
        $progress = 0;
        $tasks = Task::where('assignee_id', auth()->id())->get();
        if ($tasks) {
            $total = 0;
            foreach ($tasks as $task) {
                $total = $total + $task->progress;
            }
            $count = $tasks->count();
            if ($count != 0) {
                $progress = $total / $count;
            }
        }

        $totalAmount = Transaction::select(DB::raw('SUM(amount) as total_amount'))
            ->where('user_id', auth()->id())
            ->groupBy('user_id')->first();
        $count = Transaction::where('user_id', auth()->id())
            ->groupBy('user_id')->count();
        $totalAmountMonth = Transaction::select(DB::raw('SUM(amount) as total_amount'))
            ->where('user_id', auth()->id())
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('user_id')->first();
        $countMonth = Transaction::where('user_id', auth()->id())
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('user_id')->count();

        $leaderboard = Transaction::select(
            DB::raw('users.name'),
            DB::raw('sum(amount) as `total_amount`')
        )
            ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->groupBy('user_id')
            ->groupBy('users.name')
            ->groupBy(DB::raw("DATE_FORMAT(transactions.created_at, '%Y')"))
            ->orderBy('total_amount', 'desc')
            ->get();

        $deposit = Transaction::select(
            DB::raw("DATE_FORMAT(created_at, '%m') as month"),
            DB::raw('sum(amount) as `total_amount`')
        )
            ->where('amount', '>', 0)
            ->where('user_id', auth()->id())
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->groupBy('user_id')
            ->orderBy('month')
            ->get();

        $withdrawal = Transaction::select(
            DB::raw("DATE_FORMAT(created_at, '%m') as month"),
            DB::raw('sum(amount) as `total_amount`')
        )
            ->where('amount', '<', 0)
            ->where('user_id', auth()->id())
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->groupBy('user_id')
            ->orderBy('month')
            ->get();

        $customers = Customer::where('user_id', auth()->id())->count();

        $setting = Setting::where("name", 'reward')->first();;
        $reward = $setting != null ? $setting->value : '0';

        $result = new Transaction();
        $result->count = $count;
        $result->progress = $progress;
        $result->totalAmount = $totalAmount ? $totalAmount->total_amount : 0;
        $result->count = $count;
        $result->totalAmountMonth = $totalAmountMonth ? $totalAmountMonth->total_amount : 0;
        $result->countMonth = $countMonth;
        $result->reward = $totalAmountMonth ? $totalAmountMonth->total_amount * ($reward / 100) : 0;
        $result->leaderboard = $leaderboard;
        $result->deposit = $deposit;
        $result->withdrawal = $withdrawal;
        $result->customers = $customers;

        return view('home', compact('result'));
    }
}
