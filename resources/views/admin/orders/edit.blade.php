@extends('layouts.admin')

@section('title', 'تعديل الطلب - ' . $order->order_number)

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-edit"></i> تعديل الطلب #{{ $order->order_number }}</h3>
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary">
            <i class="fas fa-arrow-right"></i> العودة للتفاصيل
        </a>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <h4><i class="fas fa-user"></i> معلومات العميل</h4>
                    
                    <div class="form-group">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" name="customer_name" class="form-control" 
                               value="{{ old('customer_name', $order->customer_name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="customer_email" class="form-control" 
                               value="{{ old('customer_email', $order->customer_email) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="customer_phone" class="form-control" 
                               value="{{ old('customer_phone', $order->customer_phone) }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4><i class="fas fa-map-marker-alt"></i> معلومات العنوان</h4>
                    
                    <div class="form-group">
                        <label class="form-label">العنوان</label>
                        <textarea name="customer_address" class="form-control" rows="3" required>{{ old('customer_address', $order->customer_address) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">المدينة</label>
                        <input type="text" name="customer_city" class="form-control" 
                               value="{{ old('customer_city', $order->customer_city) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">حالة الطلب</label>
                        <select name="status" class="form-select" required>
                            @foreach($statuses as $status)
                                @php
                                    $statusTexts = [
                                        'pending' => 'قيد الانتظار',
                                        'processing' => 'قيد المعالجة',
                                        'completed' => 'مكتمل',
                                        'cancelled' => 'ملغي'
                                    ];
                                @endphp
                                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                    {{ $statusTexts[$status] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">ملاحظات الطلب</label>
                <textarea name="notes" class="form-control" rows="4">{{ old('notes', $order->notes) }}</textarea>
            </div>
            
            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
                
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-danger">
                    <i class="fas fa-times"></i> إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<!-- عرض عناصر الطلب -->
<div class="card mt-4">
    <div class="card-header">
        <h4><i class="fas fa-shopping-bag"></i> عناصر الطلب</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>المجموع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }} ر.س</td>
                        <td><strong>{{ number_format($item->total, 2) }} ر.س</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>المجموع الكلي:</strong></td>
                        <td><strong style="color: #27ae60;">{{ number_format($order->total, 2) }} ر.س</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection