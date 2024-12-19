<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
            ->with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,processing,shipped,delivered',
        ]);

        // Проверка последовательности статусов
        $allowedTransitions = [
            'new' => ['processing'],
            'processing' => ['shipped'],
            'shipped' => ['delivered'],
            'delivered' => [], // Доставленный заказ не может менять статус
        ];

        $currentStatus = $order->status;
        $newStatus = $validated['status'];

        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return redirect()->back()->withErrors(['status' => 'Изменение статуса недопустимо.']);
        }

        // Обновление статуса
        $order->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Статус заказа обновлен.');
    }

}
