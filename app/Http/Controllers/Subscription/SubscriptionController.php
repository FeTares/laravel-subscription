<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->subscribed('default')) {
            return redirect()->route('subscriptions.premium');
        }

        return view('subscriptions.index', [
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }

    public function store(Request $request)
    {
        $request->user()
            ->newSubscription('default', 'price_1JDd5VLsbD1rSjyAJcLAB5PI')
            ->create($request->token);

        return redirect()->route('subscriptions.premium');
    }

    public function premium()
    {
        if (!auth()->user()->subscribed('default')) {
            return redirect()->route('subscriptions.checkout');
        }

        return view('subscriptions.premium');
    }
}
