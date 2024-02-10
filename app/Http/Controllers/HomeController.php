<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Category;
use App\Models\Meal;
use App\Models\Order;
use App\Models\User;
use Notification;
use App\Notifications\SendEmailToUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
            if(Auth::user()->is_admin)
                return to_route('admin');
        $cats = Category::latest()->get();
        $meals = (!$request->category) ? Meal::latest()->paginate(6) : Meal::where('category',$request->category)->latest()->paginate(6);
        $cat1 = (!$request->category) ? 'الصفحة الرئيسية' : $request->category;
        return view('UserPage',compact(['meals','cats','cat1']));
    }

    public function toAdmin() {
        $orders = Order::latest('id')->paginate(15);
        return view('AdminPage',compact('orders'));
    }

    public function changeStatus(Request $request, Order $order) {
        $order->update(['status' => $request->status]);
        $notification = array(
			'message_id' => 'تم '.$request->status.' بنجاح !',
			'alert-type' => 'success'
		);
        Notification::send($order->user, new SendEmailToUserNotification($order));
        // Another way to send notification to the user :)
        //$user = User::find($order->user->id);
        //$user->notify(new SendEmailToUserNotification($order));
        return redirect()->back()->with($notification);
    }

    public function mealDetails(Meal $meal) {
        return view('meal.mealDetails',compact('meal'));
    }

    public function orderStore(StoreOrderRequest $request) {
        $request->validated();
        $user = auth()->user();
        Order::insert([
            'user_id' => auth()->user()->id,
            'email' => auth()->user()->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'meal_id' => $request->meal_id,
            'address' => $request->address,
            'status' => 'تتم مراجعة الطلب'
        ]);
        $notification = array(
			'message_id' => 'تم الطلب بنجاح!',
			'alert-type' => 'success'
		);

        return redirect()->back()->with($notification);
    }

    public function showOrders() {
        $orders = Order::where('user_id',auth()->user()->id)->paginate(10);
        return view('order.showOrders',compact('orders'));
    }
}
