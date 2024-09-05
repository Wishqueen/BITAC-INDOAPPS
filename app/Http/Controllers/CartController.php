<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CartController extends Controller
{
    public function addToCart(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
    
        // Retrieve cart from session or initialize if not present
        $cart = session()->get('cart', []);
    
        // Add item to cart or update existing one
        $cart[$courseId] = [
            'course_id' => $courseId,
            'title' => $course->title,
            'price' => $course->price,
        ];
    
        session()->put('cart', $cart);
    
        return redirect()->route('cart.show')->with('success', 'Course successfully added to your cart!');
    }
    

    public function showCart()
    {
        $cart = session()->get('cart', []);
        $totalPrice = array_sum(array_map(function($item) {
            return $item['price']; // Only price per item, no quantity involved
        }, $cart));

        return view('cart.index', [
            'cartItems' => $cart,
            'totalPrice' => $totalPrice
        ]);
    }

    public function removeFromCart($courseId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$courseId])) {
            unset($cart[$courseId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show');
    }


}




