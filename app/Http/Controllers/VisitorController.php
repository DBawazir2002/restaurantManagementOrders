<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request) {
        $cats = Category::latest()->get();
        $meals = (!$request->category) ? Meal::latest()->paginate(6) : Meal::where('category',$request->category)->latest()->paginate(6);
        $cat1 = (!$request->category) ? 'الصفحة الرئيسية' : $request->category;
        return view('visitorPage',compact(['meals','cats','cat1']));
    }
}
