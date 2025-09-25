@extends('layouts.admin')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-shopping-cart"></i> إدارة الطلبات</h3>
        <div class="header-actions">
            <div class="btn-group">
               
            </div>
        </div>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>تاريخ الطلب</th>
                            <th>طريقة الدفع</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $order->customer_name }}</strong>
                                    <br>
                                    <small>{{ $order->customer_email }}</small>
                                    <br>
                                    <small>{{ $order->customer_phone }}</small>
                                </div>
                            </td>
                            <td>
                                <strong style="color: #27ae60;">{{ number_format($order->total, 2) }} ر.س</strong>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $statusTexts = [
                                        'pending' => 'قيد الانتظار',
                                        'processing' => 'قيد المعالجة',
                                        'completed' => 'مكتمل',
                                        'cancelled' => 'ملغي'
                                    ];
                                @endphp
                                <span class="status-badge status-{{ $statusColors[$order->status] }}">
                                    {{ $statusTexts[$order->status] }}
                                </span>
                            </td>
                            <td>
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td>
                                @if($order->payment)
                                    @php
                                        $paymentMethods = [
                                            'visa' => 'فيزا',
                                            'apple_pay' => 'Apple Pay',
                                            'mada' => 'مدى'
                                        ];
                                    @endphp
                                    <span class="status-badge status-active">
                                        {{ $paymentMethods[$order->payment->method] ?? $order->payment->method }}
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">غير مدفوع</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-primary btn-sm"
                                       title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.orders.edit', $order) }}" 
                                       class="btn btn-info btn-sm"
                                       title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.orders.destroy', $order) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- الترقيم -->
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #6b7280;">
                <i class="fas fa-shopping-cart" style="font-size: 60px; margin-bottom: 20px;"></i>
                <h3>لا توجد طلبات</h3>
                <p>لم يتم تقديم أي طلبات حتى الآن.</p>
            </div>
        @endif
    </div>
</div>

<style>
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    .status-warning { background: #fef3cd; color: #856404; }
    .status-info { background: #d1ecf1; color: #0c5460; }
    .status-success { background: #d1fae5; color: #065f46; }
    .status-danger { background: #fee2e2; color: #b91c1c; }
    .status-active { background: #d1fae5; color: #065f46; }
    .status-inactive { background: #fee2e2; color: #b91c1c; }

    .header-actions {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    .dropdown-item {
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
    }
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
</style>
@endsection