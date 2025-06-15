<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function listForEmployee()
    {
        return response()->json(Category::select('id', 'name')->get());
    }
    public function index()
    {
        return Category::select('id', 'name')->get();
    }

    public function indexAdmin()
    {
        return response()->json(Category::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name',
            'limit_per_month' => 'required|numeric|min:0',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return response()->json([
                'message' => 'Category ditemukan',
                'data' => $category
            ]);
        } else {
            return response()->json([
                'message' => 'Category tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'limit_per_month' => 'sometimes|required|numeric',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category->fresh(), // penting untuk ambil data terbaru
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
