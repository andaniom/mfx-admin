<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
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
        return view('home', ['count' => $count, 'progress' => $progress]);
    }
}
