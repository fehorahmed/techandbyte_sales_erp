<?php

namespace Modules\Task\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Task\Entities\Task;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('task::task.all');
    }

    public function datatable()
    {
        $query = Task::with('creator','user');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Task $task) {
                return '<a href="' . route('task.task_edit', ['task' => $task->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (Task $task) {
                if ($task->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Complete</span>';
            })
            ->editColumn('task_type', function (Task $task) {
                if ($task->task_type == 1)
                    return '<span class="badge badge-secondary">Individual</span>';
                else
                    return '<span class="badge badge-info">Market visit	</span>';
            })
            ->rawColumns(['action', 'status','task_type'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users=User::all();
        return view('task::task.add',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            "title" => 'required|string|max:255',
            "user" => 'required|numeric',
            "task_type" => 'required|numeric',
            "date" => 'required|date|max:255',
            "reason" => 'nullable|string|max:255',
        ]);

        $task = new Task();
        $task->title=$request->title;
        $task->user_id=$request->user;
        $task->task_type=$request->task_type;
        $task->date=$request->date;
        $task->reason=$request->reason;
        $task->status=1;
        $task->created_by=Auth::id();
        if($task->save()){
            return redirect()->route('task.task_all')->with('message','Task Successfully Created.');
        }else{
            return redirect()->back()->with('error','Something went wrong.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('task::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $users=User::all();
        return view('task::task.edit',compact('users','task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
