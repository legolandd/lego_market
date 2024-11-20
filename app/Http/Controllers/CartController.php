<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\LegoSet;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, LegoSet $legoSet)
    {
        $quantity = $request->input('quantity', 1);

        CartItem::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lego_set_id' => $legoSet->id,
            ],
            [
                'quantity' => \DB::raw("quantity + $quantity") // Увеличиваем количество
            ]
        );

        return redirect()->back()->with('success', 'Набор добавлен в корзину.');
    }

    public function updateCartItem(Request $request, CartItem $cartItem)
    {
        $cartItem->update([
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->back()->with('success', 'Количество обновлено.');
    }
}
