@extends('layouts.admin')

@section('title', 'تفاصيل الطلب - ' . $order->order_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> تفاصيل الطلب #{{ $order->order_number }}</h3>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> العودة للقائمة
                </a>
            </div>
            <div class="card-body">
                <!-- معلومات الطلب -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><i class="fas fa-user"></i> معلومات العميل</h5>
                        <p><strong>الاسم:</strong> {{ $order->customer_name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $order->customer_email }}</p>
                        <p><strong>الهاتف:</strong> {{ $order->customer_phone }}</p>
                        <p><strong>العنوان:</strong> {{ $order->customer_address }}, {{ $order->customer_city }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-receipt"></i> معلومات الطلب</h5>
                        <p><strong>رقم الطلب:</strong> {{ $order->order_number }}</p>
                        <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                        <p><strong>الحالة:</strong> 
                            @php
                                $statusTexts = [
                                    'pending' => 'قيد الانتظار',
                                    'processing' => 'قيد المعالجة',
                                    'completed' => 'مكتمل',
                                    'cancelled' => 'ملغي'
                                ];
                            @endphp
                            <span class="status-badge status-{{ $order->status }}">
                                {{ $statusTexts[$order->status] }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- عناصر الطلب -->
                <h5><i class="fas fa-shopping-bag"></i> عناصر الطلب</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <th>الشركة</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $item->product->name }}</strong>
                                </td>
                                <td>{{ $item->product->company->name }}</td>
                                <td>{{ number_format($item->price, 2) }} ر.س</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong>{{ number_format($item->total, 2) }} ر.س</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- الملاحظات -->
                @if($order->notes)
                <div class="mt-4">
                    <h5><i class="fas fa-sticky-note"></i> ملاحظات الطلب</h5>
                    <div class="alert alert-info">
                        {{ $order->notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- ملخص الطلب -->
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-calculator"></i> ملخص الطلب</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>المجموع الجزئي:</span>
                    <span>{{ number_format($order->subtotal, 2) }} ر.س</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>الشحن:</span>
                    <span>{{ number_format($order->shipping, 2) }} ر.س</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>الضريبة:</span>
                    <span>{{ number_format($order->tax, 2) }} ر.س</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>المجموع الكلي:</strong>
                    <strong style="color: #27ae60;">{{ number_format($order->total, 2) }} ر.س</strong>
                </div>

                <!-- معلومات الدفع -->
                @if($order->payment)
                <div class="mt-4">
                    <h5><i class="fas fa-credit-card"></i> معلومات الدفع</h5>
                    <p><strong>طريقة الدفع:</strong> 
                        @php
                            $paymentMethods = [
                                'visa' => 'فيزا',
                                'apple_pay' => 'Apple Pay',
                                'mada' => 'مدى'
                            ];
                        @endphp
                        {{ $paymentMethods[$order->payment->method] ?? $order->payment->method }}
                    </p>
                    <p><strong>حالة الدفع:</strong> 
                        <span class="status-badge {{ $order->payment->status == 'completed' ? 'status-success' : 'status-warning' }}">
                            {{ $order->payment->status == 'completed' ? 'مدفوع' : 'قيد الانتظار' }}
                        </span>
                    </p>
                    <p><strong>رقم المعاملة:</strong> {{ $order->payment->payment_id }}</p>
                    @if($order->payment->paid_at)
                    <p><strong>تاريخ الدفع:</strong> {{ $order->payment->paid_at->format('Y-m-d H:i') }}</p>
                    @endif
                </div>
                @endif

                <!-- تغيير حالة الطلب -->
                <div class="mt-4">
                    <h5><i class="fas fa-sync-alt"></i> تغيير الحالة</h5>
                    <form id="statusForm">
                        @csrf
                        <select name="status" class="form-select" onchange="updateOrderStatus(this.value)">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </form>
                </div>

                <!-- الإجراءات -->
                <div class="mt-4">
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit"></i> تعديل الطلب
                    </a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                            <i class="fas fa-trash"></i> حذف الطلب
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function updateOrderStatus(status) {
        try {
            const response = await fetch('{{ route("admin.orders.update-status", $order) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            });

            const data = await response.json();

            if (data.success) {
                // إعادة تحميل الصفحة لتحديث البيانات
                location.reload();
            } else {
                alert('حدث خطأ أثناء تحديث الحالة');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث الحالة');
        }
    }
</script>

<style>
    /* تنسيقات إضافية للطلبات */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.status-warning { 
    background: #fef3cd; 
    color: #856404; 
}

.status-info { 
    background: #d1ecf1; 
    color: #0c5460; 
}

.status-success { 
    background: #d1fae5; 
    color: #065f46; 
}

.status-danger { 
    background: #fee2e2; 
    color: #b91c1c; 
}

.status-active { 
    background: #d1fae5; 
    color: #065f46; 
}

.status-inactive { 
    background: #fee2e2; 
    color: #b91c1c; 
}

/* تنسيق الترقيم */
.pagination {
    justify-content: center;
}

.pagination .page-link {
    color: #3498db;
    border: 1px solid #dee2e6;
    margin: 0 2px;
    border-radius: 5px;
}

.pagination .page-item.active .page-link {
    background: #3498db;
    border-color: #3498db;
    color: white;
}
    .status-badge {
        padding: 4px 8px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #d1ecf1; color: #0c5460; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #b91c1c; }
    .status-success { background: #d1fae5; color: #065f46; }
    .status-warning { background: #fff3cd; color: #856404; }
</style>
@endsection