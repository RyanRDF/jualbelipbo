<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class SubcategoryController extends Controller implements HasMiddleware
{

    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['index']),
        ];
    }


    public function list()
    {
        $categories = Category::all();
        return view('subkategori.index',compact('categories') );
    }
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        return response()->json([
            'data' => $subcategories
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
        $validator = Validator::make($request->all(), [
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

        $subcategory = Subcategory::create($input);

        return response()->json([
            'succsess' => true,
            'data' => $subcategory
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        return response()->json([
            'data' => $subcategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validator = Validator::make($request->all(), [
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            File::delete('uploads/' . $subcategory->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }


        $subcategory->update($input);

        return response()->json([
            'succsess' => true,
            'message' => 'Category updated successfully',
            'data' => $subcategory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        File::delete('uploads/' . $subcategory->gambar);
        $subcategory->delete();

        return response()->json([
            'succsess' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
