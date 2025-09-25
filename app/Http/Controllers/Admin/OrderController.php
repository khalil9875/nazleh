<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product', 'payment'])
                      ->latest()
                      ->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product.company', 'payment']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_city' => 'required|string|max:100',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        $order->update($request->only([
            'customer_name', 'customer_email', 'customer_phone', 
            'customer_address', 'customer_city', 'status', 'notes'
        ]));

        return redirect()->route('admin.orders.show', $order)
                         ->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // يمكن إضافة إشعار للعميل هنا عند تغيير الحالة

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الطلب بنجاح',
            'new_status' => $request->status,
            'old_status' => $oldStatus
        ]);
    }

    public function destroy(Order $order)
    {
        // حذف العناصر المرتبطة أولاً
        $order->items()->delete();
        $order->payment()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'تم حذف الطلب بنجاح');
    }
}