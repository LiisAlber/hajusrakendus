<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        // Simulate a payment outcome
        $paymentSuccessful = rand(0, 1) == 1; 

        if ($paymentSuccessful) {
            // If payment is successful, clear the cart
            session()->forget('cart');

            // Redirect to a confirmation page with a success message
            return redirect()->route('confirmation')->with('success', 'Payment processed successfully!');
        } else {
            // If payment fails, do not clear the cart
            // Redirect back to the payment page with an error message
            return back()->withErrors('Payment failed, please try again.');
        }
    }

}
