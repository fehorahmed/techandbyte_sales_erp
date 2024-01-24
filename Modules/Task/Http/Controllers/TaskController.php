<?php

namespace Modules\Task\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $query = Task::with('creator');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Task $task) {
                return '<a href="' . route('warehouse.edit', ['warehouse' => $task->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (Task $task) {
                if ($task->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
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
            "title" => 'required|string|max:255|unique:promotions,title',
            "promotion_type" => 'required|string|max:255',
            "platform" => 'required|string|max:255',
            "cost" => 'required|numeric',
            "date" => 'required|date|max:255',
            "details" => 'nullable|string|max:255',
        ]);
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
        return view('task::edit');
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
