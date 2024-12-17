<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\LegoSet;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::whereHas('legoSet', function ($query) {
            $query->where('stock', '>', 0);
        })->get();

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
        $cartItems = CartItem
            ::where('user_id', Auth::id())
            ->whereHas('legoSet', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'В корзине нет товаров, доступных для заказа.');
        }

        $total = collect($cartItems)->sum(fn($item) => $item->legoSet->price * $item['quantity']);
        $deliveryCost = 390;
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

        $fullAddress = null;
        if ($validated['delivery_method'] === 'courier') {
            $fullAddress = $validated['address']['city'] . ', ' .
                $validated['address']['street'] . ', ' .
                'дом ' . $validated['address']['house'];

            if (!empty($validated['address']['flat'])) {
                $fullAddress .= ', кв. ' . $validated['address']['flat'];
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'delivery_method' => $validated['delivery_method'],
            'total_price' => $total + $deliveryCost,
            'address' => $fullAddress,
            'delivery_date' => $validated['delivery_date'],
            'delivery_time' => $validated['delivery_time'],
            'payment_method' => $validated['payment_method'],
        ]);

        // Добавление товаров в заказ
        foreach ($cartItems as $cartItem) {
            $legoSet = LegoSet::findOrFail($cartItem->lego_set_id);
            if ($legoSet->stock - $cartItem->quantity >= $cartItem->quantity) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'lego_set_id' => $cartItem->lego_set_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->legoSet->price,
                ]);

                $legoSet->stock -= $cartItem->quantity;
                $legoSet->save();
            }
            else
                return redirect()->route('order')->with('error', 'Заказ не создан, товара не достаточно');
        }

        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }

        session()->forget('cart');

        return redirect()->route('lego_sets.index')->with('success', 'Заказ успешно создан');
    }
}
