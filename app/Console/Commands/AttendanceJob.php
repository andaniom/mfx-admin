<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Attendance date filled successfully');
        $users = User::all();
        foreach ($users as $user) {
            // check if attendance for the current date does not exist
            if (!Attendance::where('user_id', $user->id)->whereDate('date', Carbon::now()->toDateString())->exists()) {
                $attendance = new Attendance;
                $attendance->user_id = $user->id;
                $attendance->date = Carbon::now()->toDateString();
                $attendance->save();
            }
        }
        return 0;
    }
}
