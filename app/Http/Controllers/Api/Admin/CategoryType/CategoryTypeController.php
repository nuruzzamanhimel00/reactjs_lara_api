<?php

namespace App\Http\Controllers\Api\Admin\CategoryType;

use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $category_types = CategoryType::query()

        ->when(!is_null($request->search), function($query) use($request){
            $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('status', 'like', '%' . $request->search . '%');
        })
        ->when(isset($request->sortField) && !is_null($request->sortField), function($query) use($request){
            $query->orderBy(strtolower($request->sortField), $request->sortOrder == 1 ? 'asc':'desc');
        })
        ->paginate($request->rows);
        return response()->json($category_types);
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
        $category_type = CategoryType::find($id);
        if(!is_null($category_type)){
            //image delete
            //db delete
            $category_type->delete();
            return response()->json(['status' => true, 'message' => 'Deleted successfully']);

        }
    }

    public function selected_category_type_delete(Request $request)
    {
        // return ($request->all());
        $category_type = CategoryType::whereIn('id', $request->ids)->delete();
        return response()->json(['status' => true, 'message' => 'Deleted successfully']);
    }
}
