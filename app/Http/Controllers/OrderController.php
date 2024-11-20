<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder()
    {
        $cartItems = auth()->user()->cartItems;
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Ваша корзина пуста.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => 0 // Установим после подсчета
        ]);

        $total = 0;

        foreach ($cartItems as $item) {
            $discountedPrice = $item->legoSet->is_sale
                ? $item->legoSet->price * (1 - $item->legoSet->discount / 100)
                : $item->legoSet->price;

            $total += $discountedPrice * $item->quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'lego_set_id' => $item->legoSet->id,
                'quantity' => $item->quantity,
                'price' => $discountedPrice
            ]);
        }

        // Обновляем финальную стоимость заказа
        $order->update(['total' => $total]);

        // Очищаем корзину
        auth()->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Заказ успешно оформлен.');
    }
}
