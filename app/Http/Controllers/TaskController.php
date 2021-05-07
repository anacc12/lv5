<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{

    public function create(Request $request)
    {
        $id = $request->session()->get('user.id');
        $role = $request->session()->get('user.role');
        if ($role != 'teacher') return redirect('/tasks');

        Task::create([
            'title' => $request->title,
            'title_en' => $request->title_en,
            'study_type' => $request->study_type,
            'teacher_id' => $id,
        ]);

        return redirect('/tasks');
    }

    public function show(Request $request)
    {
        $id = $request->session()->get('user.id');
        $role = $request->session()->get('user.role');
        $tasks = [];

        if ($role == 'student') {
            $tasks = Task::whereNull('student_id')->with('student')->get();
        } else if ($role == 'teacher') {
            $tasks = Task::where('teacher_id', $id)->with('student')->get();
        }

        return View::make('tasks', [
            'tasks' => $tasks,
            'loggedUserRole' => $role
        ]);
    }


    public function apply(Request $request, $taskId)
    {
        $id = $request->session()->get('user.id');
        $role = $request->session()->get('user.role');
        if ($role != 'student') return view('/tasks');

        $task = Task::find($taskId);
        $task->applicants()->attach($id);
        return redirect('/tasks');
    }

    public function applicants(Request $request, $taskId)
    {
        $role = $request->session()->get('user.role');
        if ($role != 'teacher') return view('/tasks');

        $task = Task::where('id', $taskId)->with('applicants')->first();
        return View::make('applicants', [
            'applicants' => $task->applicants,
            'task' => $task
        ]);
    }

    public function approve(Request $request, $taskId, $studentId)
    {
        $id = $request->session()->get('user.id');
        $task = Task::where('id', $taskId)->with('applicants')->first();

        if ($task->teacher_id != $id) return redirect('/tasks');
        $task->student_id = $studentId;
        $task->save();

        return redirect('/tasks');
    }
}
