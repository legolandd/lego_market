<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\LegoSet;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(){
        $cartItems = CartItem::all();
        $cartTotal = $cartItems->sum(fn($item) => $item->legoSet->price * $item->quantity);
        return view ('cart.index', compact('cartItems', 'cartTotal'));
    }
    public function addToCart(Request $request, LegoSet $legoSet)
    {
        $quantity = $request->input('quantity', 1);

        CartItem::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lego_set_id' => $legoSet->id,
            ],
            [
                'quantity' => \DB::raw("quantity + $quantity")
            ]
        );

        return redirect()->back()->with('success', 'Набор добавлен в корзину.');
    }

    public function updateCartItem(Request $request, CartItem $item)
    {
        $item->update([
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->back();
    }

    public function deleteCartItem(CartItem $item)
    {
        $item->delete();

        return redirect()->back()->with('success', 'Товар удалён из корзины');
    }

}
