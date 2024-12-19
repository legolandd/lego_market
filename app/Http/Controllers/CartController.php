<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\LegoSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        // Разделяем товары на те, которые есть в наличии, и те, которых нет
        [$inStockItems, $outOfStockItems] = $cartItems->partition(fn($item) => $item->legoSet->stock > 0);

        // Итоговая сумма только для товаров, которые есть в наличии
        $cartTotal = $inStockItems->sum(fn($item) =>
            ($item->legoSet->price - $item->legoSet->price * $item->legoSet->discount / 100) * $item->quantity);

        $totalPrice = $inStockItems->sum(fn($item) => $item->legoSet->price * $item->quantity);

        return view('cart.index', compact('inStockItems', 'outOfStockItems', 'cartTotal', 'totalPrice'));
    }

    public function addToCart(Request $request, LegoSet $legoSet)
    {
        if ($legoSet->stock <= 0) {
            return redirect()->back()->withErrors(['stock' => 'Товар отсутствует в наличии.']);
        }

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
        if ($item->legoSet->stock <= 0) {
            return redirect()->back()->withErrors(['stock' => 'Товара нет в наличии, обновление невозможно.']);
        }
        $quantity = $request->input('quantity');

        $stock = LegoSet::findOrFail($item->lego_set_id)->stock;
        // Проверяем, чтобы количество было в допустимом диапазоне
        if ($quantity < 1 || $quantity > $stock) {
            return redirect()->back()->withErrors(['quantity' => 'Недопустимое количество товара.']);
        }

        $item->update([
            'quantity' => $quantity,
        ]);

        return redirect()->back();
    }


    public function deleteCartItem(CartItem $item)
    {
        $item->delete();

        return redirect()->back()->with('success', 'Товар удалён из корзины');
    }

}
