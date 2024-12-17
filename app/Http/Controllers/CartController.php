<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\LegoSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        $cartTotal = $cartItems->sum(fn($item) =>
            ($item->legoSet->price - $item->legoSet->price * $item->legoSet->discount/100) * $item->quantity);
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
                'quantity' => $quantity
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
