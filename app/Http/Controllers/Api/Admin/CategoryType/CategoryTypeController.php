<?php

namespace App\Http\Controllers\Api\Admin\CategoryType;

use App\Models\File;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $category_types = CategoryType::query()
            ->with(['file'])
            ->when(!is_null($request->search), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('status', 'like', '%' . $request->search . '%');
            })
            ->when(isset($request->sortField) && !is_null($request->sortField), function ($query) use ($request) {
                $query->orderBy(strtolower($request->sortField), $request->sortOrder == 1 ? 'asc' : 'desc');
            })
            ->when(is_null($request->sortField), function ($query) use ($request) {
                $query->orderBy('id', 'desc');
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

        $validated = $request->validate([
            'name' => 'required|unique:category_types',
            'status' => 'required',
            'file' => 'required',
        ]);
        try {
            //category type created
            $category_type = CategoryType::create([
                'name' => $request->name,
                'status' => CategoryType::STATUS_ACTIVE,
            ]);

            //if file exist
            $category_file = [];
            if (!empty($request['file']) && !is_null($category_type)) {
                //image store
                $file = $request['file'];
                $category_file['name'] = store_file($file['path'], File::FILE_STORE_PATH);
                $category_file['type'] = $file['type'];
                $category_file['status'] = File::STATUS_ACTIVE;
                //image store into db
                $category_type->file()->create($category_file);

            }

            return response()->json([
                'status' => true,
                'message' => 'Created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category_type = CategoryType::query()
            ->with(['file'])
            ->find($id);
        return response()->json($category_type);
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
        $validated = $request->validate([
            'name' => 'required|unique:category_types,name,' . $id . '',
            'status' => 'required',
            'file' => 'required',
        ]);

        $category_type = CategoryType::query()
            ->with(['file'])
            ->updateOrCreate(['id' => $request->id], $request->all());

        if (!empty($request['file'])) {
            $file = $request['file'];
            if (base64_path_check($file['path'])) {
                if (!is_null($category_type->file)) {

                    delete_file(File::FILE_STORE_PATH . "/" . $category_type->file->name);
                    $category_type->file()->delete();
                }

                $category_file['name'] = store_file($file['path'], File::FILE_STORE_PATH);
                $category_file['type'] = $file['type'];
                $category_file['status'] = File::STATUS_ACTIVE;
                //image store into db
                $category_type->file()->create($category_file);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category_type = CategoryType::query()->with(['file'])->find($id);
        if (!is_null($category_type)) {
            if(!is_null($category_type->file)){

                //image delete
                delete_file(File::FILE_STORE_PATH . "/" . $category_type->file->name);
                $category_type->file->delete();
            }
            //db delete
            $category_type->delete();
            return response()->json(['status' => true, 'message' => 'Deleted successfully']);

        }
    }

    public function selected_category_type_delete(Request $request)
    {
        // return ($request->all());
        $category_type = CategoryType::query()
            ->with(['file'])
            ->whereIn('id', $request->ids)
            ->get();
        if (count($category_type) > 0) {
            foreach ($category_type as $cat) {
                if (!is_null($cat->file)) {

                    //image delete
                    delete_file(File::FILE_STORE_PATH . "/" . $cat->file->name);
                    $cat->file->delete();
                }
                //db delete
                $cat->delete();
            }


            return response()->json(['status' => true, 'message' => 'Deleted successfully']);
        }

    }
}
