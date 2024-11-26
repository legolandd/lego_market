<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::all();
        $user = Auth::user();
        $total = collect($cartItems)->sum(fn($item) => $item->legoset->price * $item['quantity']);
        $deliveryCost = 390;

        return view('order.index', [
            'user' => $user,
            'cartItems' => $cartItems,
            'total' => $total + $deliveryCost,
            'deliveryCost' => $deliveryCost,
        ]);
    }

    public function store(Request $request)
    {
        $cartItems = CartItem::all();
        $total = collect($cartItems)->sum(fn($item) => $item->legoSet->price * $item['quantity']);
        $deliveryCost = 390;
        try {
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email',
            'delivery_method' => 'required|in:courier,pickup',
            'address.city' => 'required_if:delivery_method,courier|string',
            'address.street' => 'required_if:delivery_method,courier|string',
            'address.house' => 'required_if:delivery_method,courier|string',
            'address.flat' => 'nullable|string',
            'delivery_date' => 'required|date',
            'delivery_time' => 'required|string',
            'payment_method' => 'required|in:cash,card',
        ]);
        } catch (\Illuminate\Validation\ValidationException $e) {    dd($e->errors());
        }

        $fullAddress = null;
        if ($validated['delivery_method'] === 'courier') {
            $fullAddress = $validated['address']['city'] . ', ' .
                $validated['address']['street'] . ', ' .
                'дом ' . $validated['address']['house'];

            if (!empty($validated['address']['flat'])) {
                $fullAddress .= ', кв. ' . $validated['address']['flat'];
            }
        }

        Order::create([
            'user_id' => Auth::id(),
            'delivery_method' => $validated['delivery_method'],
            'total_price' => $total + $deliveryCost,
            'address' => $fullAddress,
            'delivery_date' => $validated['delivery_date'],
            'delivery_time' => $validated['delivery_time'],
            'payment_method' => $validated['payment_method'],
        ]);

        session()->forget('cart');

        return redirect()->route('lego_sets.index')->with('success', 'Заказ успешно создан');
    }
}
