<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->get();
        $ordersCount = Order::where('user_id', $user->id)->count();
        return view('profile.index', compact('orders', 'ordersCount'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Профиль успешно обновлен.');
    }
}
