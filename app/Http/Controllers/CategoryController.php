<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Colocation $colocation){
        $categories = $colocation->categories;

        return view('categories.index', compact('colocation','categories'));
    }

    public function store(StoreCategoryRequest $request, Colocation $colocation)
    {
        
    $request->validated();
        
    

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

