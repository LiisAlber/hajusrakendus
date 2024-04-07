<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->input('product_id'));
        $cart = session()->get('cart', []);

        // check if the product is already in the cart
        if (isset($cart[$product->id])) {
            // if it is, increment the quantity
            $cart[$product->id]['quantity'] += $request->input('quantity');
        } else {
            // if not, add the product to the cart with the specified quantity
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->input('quantity'),
            ];
        }

        // update the session with the cart data
        session()->put('cart', $cart);

        // redirect to the cart index route
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function destroy($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed successfully.');
    }

    public function index()
    {
        $cart = session()->get('cart');
        $totalAmount = 0;

        if ($cart) {
            foreach ($cart as $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }
        }

        return view('products.cart', compact('totalAmount'));
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
    }
}
