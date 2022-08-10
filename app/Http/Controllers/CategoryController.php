<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id')->get();
        return view('category.index', [
            'title' => 'master | category',
            'categories' => $categories
        ]);
    }

    public function addCategory(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();

        return response()->json($category);
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function updateCategory(Request $request)
    {
        $category = Category::find($request->id);
        $category->category_name = $request->category_name;
        $category->save();
        return response()->json($category);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['success' => 'Record has been deleted']);
    }
}
