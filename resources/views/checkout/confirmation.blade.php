<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .confirmation-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
        }

        .success-icon {
            font-size: 4em;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .confirmation-title {
            font-size: 2.5em;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .order-number {
            font-size: 1.3em;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .confirmation-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 30px 0;
            text-align: left;
        }

        @media (max-width: 768px) {
            .confirmation-details {
                grid-template-columns: 1fr;
            }
        }

        .detail-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }

        .detail-title {
            font-size: 1.2em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: 600;
            color: #7f8c8d;
        }

        .detail-value {
            color: #2c3e50;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #219a52;
            transform: translateY(-2px);
        }

        .order-items {
            margin: 20px 0;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .item-name {
            font-weight: 600;
        }

        .item-total {
            color: #27ae60;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h1 class="confirmation-title">Order Confirmed!</h1>
            <p class="order-number">Order #: {{ $order->order_number }}</p>
            
            <p style="font-size: 1.1em; color: #7f8c8d; margin-bottom: 30px;">
                Thank you for your purchase! Your order is being processed and you will receive a confirmation email shortly.
            </p>

            <div class="confirmation-details">
                <!-- Order Summary -->
                <div class="detail-section">
                    <h3 class="detail-title">
                        <i class="fas fa-receipt"></i> Order Summary
                    </h3>
                    <div class="order-items">
                        @foreach($order->items as $item)
                        <div class="order-item">
                            <span class="item-name">{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span class="item-total">${{ number_format($item->total, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Subtotal:</span>
                        <span class="detail-value">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Shipping:</span>
                        <span class="detail-value">${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tax:</span>
                        <span class="detail-value">${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="detail-item" style="border-top: 2px solid #ecf0f1; padding-top: 10px; font-weight: 700;">
                        <span class="detail-label">Total:</span>
                        <span class="detail-value" style="color: #27ae60;">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Payment & Shipping -->
                <div class="detail-section">
                    <h3 class="detail-title">
                        <i class="fas fa-shipping-fast"></i> Delivery Details
                    </h3>
                    <div class="detail-item">
                        <span class="detail-label">Name:</span>
                        <span class="detail-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $order->customer_email }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Address:</span>
                        <span class="detail-value">{{ $order->customer_address }}, {{ $order->customer_city }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Payment Method:</span>
                        <span class="detail-value" style="text-transform: capitalize;">
                            {{ str_replace('_', ' ', $order->payment->method) }}
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value" style="color: #27ae60; font-weight: 600;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i> Continue Shopping
                </a>
                <a href="#" class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Receipt
                </a>
            </div>

            <p style="margin-top: 30px; color: #7f8c8d; font-size: 0.9em;">
                You will receive an email confirmation within 5 minutes. 
                For any questions, contact us at support@nazleh.com
            </p>
        </div>
    </div>

    <script>
        // طباعة الصفحة تلقائياً (اختياري)
        // window.print();
    </script>
</body>
</html>