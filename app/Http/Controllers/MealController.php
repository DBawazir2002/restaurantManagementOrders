<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meals = Meal::latest()->paginate(3);
        return view('meal.index',compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Category::latest()->get();
        return view('meal.createMeal',compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealRequest $request)
    {
        $request->validated();
        $image = $request->file('image');
        $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $imageURL = 'upload/Meals/'.$imageName;
        Image::make($image)->resize(300,300)->save('storage/upload/Meals/'.$imageName);
        Meal::insert([
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageURL,
        ]);

        $notification = array(
			'message_id' => 'تم الاضافة بنجاح!',
			'alert-type' => 'success'
		);

        return redirect()->route('meal.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        $cats = Category::latest()->get();
        return view('meal.editMeal',compact(['meal','cats']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMealRequest $request, Meal $meal)
    {
        $request->validated();
        if($request->file('image')){
            $oldImage = $request->old_image;
            Image::make('storage/'.$oldImage)->destroy();
            //This Also used to delete a file:  unlink($oldImage);
            $image = $request->file('image');
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $imageURL = 'upload/Meals/'.$imageName;
            Image::make($image)->resize(300,300)->save('storage/upload/Meals/'.$imageName);
            $meal->update([
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $imageURL,
            ]);
        }
        else{
            $meal->update([
                'category' => $request->category,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);
        }
        $notification = array(
			'message_id' => 'تم التعديل بنجاح!',
			'alert-type' => 'success'
		);

        return redirect()->route('meal.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        Image::make('storage/'.$meal->image)->destroy();
        $meal->delete();
        $notification = array(
			'message_id' => 'تم الحذف بنجاح!',
			'alert-type' => 'success'
		);

        return redirect()->route('meal.index')->with($notification);
    }
}
