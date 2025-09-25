<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Nazleh Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* الشريط الجانبي */
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 0;
        }

        .sidebar-header {
            padding: 25px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 18px 25px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
            border-right: 4px solid transparent;
        }

        .nav-item:hover,
        .nav-item.active {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border-right-color: #2ecc71;
        }

        .nav-item i {
            width: 25px;
            margin-left: 15px;
            font-size: 18px;
        }

        /* المحتوى الرئيسي */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* الهيدر */
        .admin-header {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e74c3c 0%, #e67e22 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        /* المحتوى */
        .admin-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* الكاردات */
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .card-body {
            padding: 25px;
        }

        /* الأزرار */
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9 0%, #2573a7 100%);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60 0%, #219a52 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #219a52 0%, #1e8849 100%);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c0392b 0%, #a33224 100%);
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 14px;
        }

        /* الجدول */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: right;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 700;
            color: #2c3e50;
        }

        .table tr:hover {
            background: #f8f9fa;
        }

        /* الفورم */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Tajawal', sans-serif;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .form-select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            background: white;
            font-family: 'Tajawal', sans-serif;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* التنبيهات */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 2px solid #a7f3d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #b91c1c;
            border: 2px solid #fecaca;
        }

        /* الصور */
        .category-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .image-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 20px;
        }

        /* حالة التصنيف */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* responsive */
        @media (max-width: 1024px) {
            .admin-container {
                flex-direction: column;
            }
            
            .admin-sidebar {
                width: 100%;
                order: 2;
            }
            
            .admin-main {
                order: 1;
            }
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .admin-content {
                padding: 20px;
            }
            
            .card-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .table {
                font-size: 14px;
            }
            
            .table th,
            .table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- الشريط الجانبي -->
                <!-- الشريط الجانبي -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-crown"></i> Nazleh Admin</h2>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>لوحة التحكم</span>
            </a>
            

            <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i>
                <span>المنتجات</span>
            </a>
           <a href="{{ route('admin.makeup-products.index') }}" class="nav-item">
    <i class="fas fa-shopping-bag"></i>
    <span>منتجات المكياج</span>
</a>
            
            <a href="{{ route('admin.companies.index') }}" class="nav-item {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i>
                <span>إدارة الشركات</span>
            </a>
            
        <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
    <i class="fas fa-shopping-cart"></i>
    <span>الطلبات</span>
</a>
       
            <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                @csrf
                <button type="submit" class="nav-item" style="background: none; border: none; width: 100%; text-align: right;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </aside>


        <!-- المحتوى الرئيسي -->
        <main class="admin-main">
            <!-- الهيدر -->
            <header class="admin-header">
                <h1>@yield('title', 'لوحة التحكم')</h1>
                
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight: 700;">{{ Auth::user()->name }}</div>
                        <div style="color: #6b7280; font-size: 14px;">مدير النظام</div>
                    </div>
                </div>
            </header>

            <!-- المحتوى -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // تأثيرات التحويم
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn');
            const cards = document.querySelectorAll('.card');
            
            buttons.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.transition = 'transform 0.3s ease';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>