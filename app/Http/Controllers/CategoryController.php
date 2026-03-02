<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Colocation $colocation){
        $categories = $colocation->categories;

        return view('categories.index', compact('colocation','categories'));
    }

    public function store(Request $request, Colocation $colocation)
    {
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    Category::create([
        'name' => $request->name,
        'colocation_id' => $colocation->id
    ]);

    return back()->with('success', 'Category créée');
    }

    public function destroy(Category $category)
    {
    $category->delete();

    return back();
    }
}

