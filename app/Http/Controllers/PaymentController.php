<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function getPaymentMethods(): JsonResponse
    {
        try {
            $paymentMethods = [
                [
                    'id' => 'credit_card',
                    'name' => 'Credit Card',
                    'description' => 'Pay with Visa, MasterCard, or American Express',
                    'icon' => 'fas fa-credit-card',
                    'enabled' => true
                ],
                [
                    'id' => 'paypal',
                    'name' => 'PayPal',
                    'description' => 'Pay with your PayPal account',
                    'icon' => 'fab fa-paypal',
                    'enabled' => true
                ],
                [
                    'id' => 'bank_transfer',
                    'name' => 'Bank Transfer',
                    'description' => 'Direct bank transfer',
                    'icon' => 'fas fa-university',
                    'enabled' => true
                ],
                [
                    'id' => 'apple_pay',
                    'name' => 'Apple Pay',
                    'description' => 'Pay with Apple Pay',
                    'icon' => 'fab fa-apple-pay',
                    'enabled' => false
                ]
            ];
            
            return response()->json($paymentMethods);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function processPayment(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'payment_method' => 'required|string',
                'amount' => 'required|numeric|min:0'
            ]);

            $order = Order::findOrFail($validated['order_id']);
            
            if ($order->payment_status === 'paid') {
                return response()->json(['error' => 'Order already paid'], 400);
            }

            // Validate amount matches order total
            if (abs((float)$order->total_amount - (float)$validated['amount']) > 0.01) {
                return response()->json(['error' => 'Payment amount does not match order total'], 400);
            }

            // Simulate payment processing
            $transactionId = 'TXN_' . date('YmdHis') . '_' . strtoupper(Str::random(8));
            
            // Simulate payment success/failure (90% success rate)
            $paymentSuccess = rand(1, 10) <= 9;
            
            if ($paymentSuccess) {
                // Update order with payment information
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => $validated['payment_method'],
                    'payment_transaction_id' => $transactionId,
                    'status' => 'confirmed'
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'transaction_id' => $transactionId,
                    'order' => $order->load('items')
                ]);
            } else {
                // Simulate payment failure
                return response()->json([
                    'success' => false,
                    'error' => 'Payment failed. Please try again or use a different payment method.',
                    'error_code' => 'PAYMENT_DECLINED'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function validateCard(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'card_number' => 'required|string',
                'expiry_month' => 'required|integer|min:1|max:12',
                'expiry_year' => 'required|integer|min:' . date('Y'),
                'cvv' => 'required|string|min:3|max:4'
            ]);

            $cardNumber = preg_replace('/\D/', '', $validated['card_number']);
            $expiryMonth = $validated['expiry_month'];
            $expiryYear = $validated['expiry_year'];
            $cvv = $validated['cvv'];

            // Basic validation
            $errors = [];

            // Card number validation
            if (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
                $errors[] = 'Invalid card number';
            }

            // Expiry date validation
            $currentYear = (int)date('Y');
            $currentMonth = (int)date('n');
            
            if ($expiryYear < $currentYear || ($expiryYear == $currentYear && $expiryMonth < $currentMonth)) {
                $errors[] = 'Card has expired';
            }

            // CVV validation
            if (!ctype_digit($cvv) || strlen($cvv) < 3 || strlen($cvv) > 4) {
                $errors[] = 'Invalid CVV';
            }

            if (!empty($errors)) {
                return response()->json(['valid' => false, 'errors' => $errors], 400);
            }

            // Determine card type
            $cardType = 'Unknown';
            if (str_starts_with($cardNumber, '4')) {
                $cardType = 'Visa';
            } elseif (preg_match('/^5[1-5]/', $cardNumber)) {
                $cardType = 'MasterCard';
            } elseif (preg_match('/^3[47]/', $cardNumber)) {
                $cardType = 'American Express';
            }

            return response()->json([
                'valid' => true,
                'card_type' => $cardType,
                'last_four' => substr($cardNumber, -4)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function processRefund(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'amount' => 'required|numeric|min:0',
                'reason' => 'required|string'
            ]);

            $order = Order::findOrFail($validated['order_id']);
            
            if ($order->payment_status !== 'paid') {
                return response()->json(['error' => 'Order is not paid, cannot refund'], 400);
            }

            $refundAmount = (float)$validated['amount'];
            
            // Validate refund amount
            if ($refundAmount > (float)$order->total_amount) {
                return response()->json(['error' => 'Refund amount cannot exceed order total'], 400);
            }

            // Simulate refund processing
            $refundId = 'REF_' . date('YmdHis') . '_' . strtoupper(Str::random(8));
            
            // Update order status
            if ($refundAmount == (float)$order->total_amount) {
                $order->update([
                    'payment_status' => 'refunded',
                    'status' => 'cancelled'
                ]);
            } else {
                $order->update(['payment_status' => 'partially_refunded']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully',
                'refund_id' => $refundId,
                'refund_amount' => $refundAmount,
                'order' => $order->load('items')
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getPaymentStatus($transactionId): JsonResponse
    {
        try {
            $order = Order::where('payment_transaction_id', $transactionId)->first();
            
            if (!$order) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }

            return response()->json([
                'transaction_id' => $transactionId,
                'status' => $order->payment_status,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'amount' => (float)$order->total_amount,
                'payment_method' => $order->payment_method
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
