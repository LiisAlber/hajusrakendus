<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => 1000, 
                'currency' => 'eur',
                'source' => $request->stripeToken, 
                'description' => 'Payment Description',
            ]);

            if ($charge->paid) {
                session()->forget('cart');
                return redirect()->route('confirmation')->with('success', 'Payment processed successfully!');
            } else {
                return back()->withErrors('Payment failed, please try again.');
            }
        } catch (\Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }
}
