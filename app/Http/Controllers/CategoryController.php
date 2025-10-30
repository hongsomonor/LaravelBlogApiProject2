<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Category::all()]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $categories = Category::create($data);

        return response()->json(['data' => $categories]);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'error' => 'Category not found'
            ]);
        }

        return response()->json(['category' => $category]);
    }

    public function update(StoreCategoryRequest $request,$id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'error' => 'Category not found'
            ]);
        }

        $data = $request->validated();
        $category->update($data);

        return response()->json(['category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'error' => 'Category not found'
            ]);
        }

        $category->delete();

        return response()->json(['message' => 'deleted successfully']);
    }
}
