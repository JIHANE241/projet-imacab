<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|unique:categories']);
        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['nom' => 'required|string|unique:categories,nom,' . $category->id]);
        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour.');
    }

    public function destroy(Category $category)
    {
        if ($category->offres()->exists()) {
            return back()->with('error', 'Impossible de supprimer une catégorie utilisée par des offres.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée.');
    }
}