<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(5);
        return view('task.tasks', ['tasks' => $tasks]);
    }

    public function create()
    {
        return view('task.task-create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'task' => 'required',
        ]);

        $task = Task::create([
            'description' => $request->task,
            'date' => now(),
        ]);
        error_log('Some message here.');
        error_log($task);

        if ($task) {
            return redirect()->route('tasks.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('tasks.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
}
