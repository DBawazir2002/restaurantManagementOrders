<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $cats = Category::paginate(3);
        return view('category.CategoryPage',compact('cats'));
    }

    public function store(StoreCategoryRequest $request) {
        $request->validated();
        Category::insert([
            'cat_name' => $request->cat_name,
            'created_at' => now()
        ]);
        return back()->with('message','تم اضافة صنف جديد !');
    }

    public function update(UpdateCategoryRequest $request){
        $request->validated();
        Category::findOrFail($request->id)->update(['cat_name' => $request->cat_name]);
        return to_route('cat.index')->with('message','تم تعديل الصنف بنجاح');
    }

    public function delete(Category $category) {
        $category->delete();
        return to_route('cat.index')->with('message','تم حذف الصنف بنجاح');
    }
}
