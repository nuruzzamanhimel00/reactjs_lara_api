<?php

namespace App\Http\Controllers\Api\Admin\Category;

use App\Models\File;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Category::query()
            ->with(['parent', 'file'])
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
        return response()->json($data);
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
        $data = Category::query()->with(['file','allCategories.file'])->find($id);

        if (!is_null($data)) {
            if (!is_null($data->file)) {

                //image delete
                delete_file(File::FILE_STORE_PATH . "/" . $data->file->name);
                $data->file()->delete();
            }
            //all childed category data and file delte
            if (!is_null($data->allCategories)) {
                foreach($data->allCategories as $child_cat){
                    if (!is_null($child_cat->file)) {
                        //image delete
                        delete_file(File::FILE_STORE_PATH . "/" . $child_cat->file->name);
                        $child_cat->file()->delete();
                    }
                    $child_cat->delete();
                }
            }
            //db delete
            $data->delete();
            return response()->json(['status' => true, 'message' => 'Deleted successfully']);

        }
    }
}
