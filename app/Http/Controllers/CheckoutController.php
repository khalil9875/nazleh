<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        $tax = $subtotal * 0.1;
        $shipping = 10.00;
        $total = $subtotal + $tax + $shipping;

        return view('checkout.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_city' => 'required|string|max:100',
            'payment_method' => 'required|in:visa,apple_pay,mada',
            'notes' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request) {
            // الحصول على عناصر السلة
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
            
            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            // حساب المجاميع
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
            $tax = $subtotal * 0.1;
            $shipping = 10.00;
            $total = $subtotal + $tax + $shipping;

            // إنشاء الطلب
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'customer_city' => $request->customer_city,
                'customer_country' => $request->customer_country ?? 'Saudi Arabia',
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // إضافة عناصر الطلب
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->quantity * $item->product->price
                ]);
            }

            // إنشاء سجل الدفع
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_id' => 'PAY-' . uniqid(),
                'method' => $request->payment_method,
                'amount' => $total,
                'currency' => 'SAR',
                'status' => 'pending'
            ]);

            // معالجة الدفع حسب الطريقة
            $paymentResult = $this->processPayment($payment, $request);

            if ($paymentResult['success']) {
                // تحديث حالة الدفع
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'payment_details' => $paymentResult['details']
                ]);

                // تحديث حالة الطلب
                $order->update(['status' => 'processing']);

                // تفريغ السلة
                Cart::where('user_id', Auth::id())->delete();

                return response()->json([
                    'success' => true,
                    'order_id' => $order->id,
                    'message' => 'Order placed successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => $paymentResult['error']
                ], 400);
            }
        });
    }

    private function processPayment(Payment $payment, Request $request)
    {
        // محاكاة واجهات الدفع الحقيقية
        $method = $payment->method;
        
        try {
            switch ($method) {
                case 'visa':
                    return $this->processVisaPayment($payment, $request);
                    
                case 'apple_pay':
                    return $this->processApplePayPayment($payment, $request);
                    
                case 'mada':
                    return $this->processMadaPayment($payment, $request);
                    
                default:
                    throw new \Exception('Unsupported payment method');
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function processVisaPayment(Payment $payment, Request $request)
    {
        // محاكاة API فيزا (يمكن استبدالها بـ Stripe أو Paypal)
        $apiKey = config('services.visa.api_key');
        
        // محاكاة نجاح الدفع (في البيئة الحقيقية هنا ستكون request لـ API)
        $success = rand(0, 100) > 10; // 90% success rate for demo
        
        if ($success) {
            return [
                'success' => true,
                'details' => [
                    'transaction_id' => 'TXN-' . uniqid(),
                    'gateway' => 'Visa',
                    'authorization_code' => strtoupper(uniqid()),
                    'timestamp' => now()->toISOString()
                ]
            ];
        } else {
            throw new \Exception('Visa payment failed: Insufficient funds');
        }
    }

    private function processApplePayPayment(Payment $payment, Request $request)
    {
        // محاكاة Apple Pay
        $success = rand(0, 100) > 5; // 95% success rate
        
        if ($success) {
            return [
                'success' => true,
                'details' => [
                    'transaction_id' => 'APY-' . uniqid(),
                    'gateway' => 'Apple Pay',
                    'device_id' => 'iPhone_' . rand(1000, 9999),
                    'timestamp' => now()->toISOString()
                ]
            ];
        } else {
            throw new \Exception('Apple Pay payment failed: Authentication required');
        }
    }

    private function processMadaPayment(Payment $payment, Request $request)
    {
        // محاكاة مدى
        $success = rand(0, 100) > 3; // 97% success rate
        
        if ($success) {
            return [
                'success' => true,
                'details' => [
                    'transaction_id' => 'MDA-' . uniqid(),
                    'gateway' => 'Mada',
                    'authorization_code' => strtoupper(uniqid()),
                    'timestamp' => now()->toISOString()
                ]
            ];
        } else {
            throw new \Exception('Mada payment failed: Transaction declined');
        }
    }

    public function orderConfirmation($orderId)
    {
        $order = Order::with(['items.product', 'payment'])
                     ->where('user_id', Auth::id())
                     ->findOrFail($orderId);

        return view('checkout.confirmation', compact('order'));
    }
}