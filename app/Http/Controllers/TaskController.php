<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('assignee_id', auth()->id())->paginate(5);
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        $taskHistories = TaskHistory::where('task_id', $id)
            ->leftJoin('users as assigned_user', 'task_histories.updated_by', '=', 'assigned_user.id')
            ->paginate(5);
        return view('tasks.show', compact('task', 'taskHistories'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'assignee_id' => 'required|exists:users,id',
            'progress' => 'required|integer|min:0|max:100',
            'status' => 'required|in:' . implode(',', Task::STATUSES),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task = new Task;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status = 'Pending';
        $task->assignee_id = $request->input('assignee_id');
        $task->save();

        // Create tasks history
        $taskHistory = new TaskHistory;
        $taskHistory->task_id = $task->id;
        $taskHistory->old_status = null;
        $taskHistory->new_status = 'Pending';
        $taskHistory->updated_by = auth()->user()->id;
        $taskHistory->save();

        notify()->success('Task created successfully.');
        return redirect()->route('tasks.index');
    }

    public function edit(int $id = null)
    {
        $assignees = User::all();
        $statuses = Task::STATUSES;

        $task = Task::findOrFail($id);

        return view('tasks.form', [
            'task' => $task,
            'assignees' => $assignees,
            'statuses' => $statuses
        ]);
    }

    public function create()
    {
        $assignees = User::all();
        $statuses = Task::STATUSES;

        return view('tasks.form', [
            'assignees' => $assignees,
            'statuses' => $statuses
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'assignee_id' => 'required|exists:users,id',
            'progress' => 'required|integer|min:0|max:100',
            'status' => 'required|in:' . implode(',', Task::STATUSES),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task = Task::findOrFail($id);
        $oldStatus = $task->status;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status = $request->input('status');
        $task->assignee_id = $request->input('assignee_id');
        $task->progress = $request->input('progress');
        if ($request->input('progress') == 100 || $request->input('status') == 'Finished') {
            $task->status = 'Finished';
            $task->progress = 100;
        }
        $task->save();

        // Create tasks history
        $taskHistory = new TaskHistory;
        $taskHistory->task_id = $id;
        $taskHistory->old_status = $oldStatus;
        $taskHistory->new_status = $request->input('status');
        $taskHistory->updated_by = auth()->user()->id;
        $taskHistory->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }
}
