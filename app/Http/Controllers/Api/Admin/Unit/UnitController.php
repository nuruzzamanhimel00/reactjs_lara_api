<?php

namespace App\Http\Controllers\Api\Admin\Unit;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Unit::query()
            ->with(['parent'])
            ->when(!is_null($request->search), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%');
                })->orWhere(function ($query) use ($request) {
                    $query->whereHas('parent', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    });
                });

        })
        ->when(isset($request->sortField) && !is_null($request->sortField), function($query) use($request){
            $query->orderBy(strtolower($request->sortField), $request->sortOrder == 1 ? 'asc':'desc');
        })
        ->when( is_null($request->sortField), function($query) use($request){
            $query->orderBy('id','desc');
        })
        ->paginate($request->rows);

        $baseUnits = Unit::where('status', Unit::STATUS_ACTIVE)
        ->baseUnit()
        ->get();

        return response()->json([

            'data' => $data,
            'base_units' => $baseUnits
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
