<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $sessionId = $request->header('X-Session-ID', session()->getId());
            
            $orders = Order::with('items')
                ->where('session_id', $sessionId)
                ->orderBy('created_at', 'desc')
                ->get();
                
            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $order = Order::with('items')->findOrFail($id);
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:100',
                'customer_email' => 'required|email|max:120',
                'customer_phone' => 'nullable|string|max:20',
                'shipping_address' => 'required|string',
                'shipping_city' => 'required|string|max:100',
                'shipping_country' => 'required|string|max:100',
                'shipping_postal_code' => 'nullable|string|max:20'
            ]);

            $sessionId = $request->header('X-Session-ID', session()->getId());
            
            // Get cart
            $cart = Cart::with('items.product')
                ->where('session_id', $sessionId)
                ->first();
                
            if (!$cart || $cart->items->isEmpty()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            // Calculate total
            $totalAmount = $cart->getTotal();

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'session_id' => $sessionId,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_country' => $validated['shipping_country'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending'
            ]);

            // Create order items
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'product_name' => $cartItem->product->name
                ]);
            }

            // Clear cart
            $cart->items()->delete();

            return response()->json($order->load('items'), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|in:pending,confirmed,shipped,delivered,cancelled'
            ]);

            $order = Order::findOrFail($id);
            $order->update(['status' => $validated['status']]);

            return response()->json($order->load('items'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cancel($id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);
            
            if ($order->status === 'shipped' || $order->status === 'delivered') {
                return response()->json(['error' => 'Cannot cancel shipped or delivered orders'], 400);
            }

            $order->update(['status' => 'cancelled']);
            return response()->json($order->load('items'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
