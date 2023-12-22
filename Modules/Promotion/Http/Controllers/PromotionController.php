<?php

namespace Modules\Promotion\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Promotion\Entities\Promotion;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('promotion::promotion.index');
    }

    public function datatable()
    {
        $query = Promotion::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Promotion $promotion) {
                return '<a href="' . route('promotion.edit', ['promotion' => $promotion->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('promotion::promotion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            "title" => 'required|string|max:255',
            "promotion_type" => 'required|string|max:255',
            "platform" => 'required|string|max:255',
            "cost" => 'required|numeric',
            "date" => 'required|date|max:255',
            "details" => 'nullable|string|max:255',
        ]);

        $data = new Promotion();
        $data->title = $request->title;
        $data->promotion_type = $request->promotion_type;
        $data->platform = $request->platform;
        $data->cost = $request->cost;
        $data->date = $request->date;
        $data->details = $request->details;
        $data->created_by = Auth::id();
        if ($data->save()) {
            return redirect()->route('promotion.index')->with('message', 'Information added');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('promotion::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('promotion::promotion.edit');
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
