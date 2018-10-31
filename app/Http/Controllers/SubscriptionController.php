<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            if( auth()->user()->subscribed('main')){
                return redirect('/')->with('message', ['type'=>'warning', 'text' => __('Ya estás suscrito a otro plan')]);
            }
            return $next($request);
        })->only(['plans', 'processSubscription']);
    }

    public function plans(){
        return view('subscriptions.plans');
    }
    public function process_subscription(Request $request){
        $token = \request('stripeToken');
        try{
            if($request->has('coupon')){
                $request->user()->newSubscription('main', $request->get('type'))->withCoupon($request->get('coupon'))->create($token);
            }else{
                $request->user()->newSubscription('main', $request->get('type'))->create($token);
            }
            return redirect(route('subscriptions.admin'))->with('message', ['type' => 'success', 'text'=>__('La suscripcion se ha llevado a cabo correctamente')]);

        }catch (\Exception $exception){
            $error = $exception->getMessage();
            return back()->with('message', ['type' => 'danger', 'text' => $error]);
        }
    }

    public function admin(){
        $subscriptions = auth()->user()->subscriptions;
        return view('subscriptions.admin')->with(compact('subscriptions'));
    }

    public function resume(Request $request){
        $subscription = $request->user()->subscription($request->get('plan'));
        if($subscription->cancelled() && $subscription->onGracePeriod()){
            $request->user()->subscription($request->get('plan'))->resume();
            return back()->with('message', ['type' => 'success', 'text' => __('Has reanudado tu suscripción correctamente')]);
        }
        return back();
    }

    public function cancel(Request $request){
        auth()->user()->subscription($request->get('plan'))->cancel();
        return back()->with('message', ['type' => 'danger', 'text' => __('Has cancelado tu suscripción correctamente')]);
    }
}
