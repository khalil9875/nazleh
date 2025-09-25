@extends('layouts.admin')

@section('title', 'إدارة الشركات')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-building"></i> إدارة الشركات</h3>
        <a href="{{ route('admin.companies.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة شركة جديدة
        </a>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($companies->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>صورة الشركة</th>
                            <th>اسم الشركة</th>
                            <th>تاريخ الإضافة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                               @if($company->logo)
    <img src="{{ asset('images/companies/' . $company->logo) }}" 
         alt="{{ $company->name }}" 
         class="company-image"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" width=50>
@else
    <div class="image-placeholder">
        <i class="fas fa-building"></i>
    </div>
@endif
                            </td>
                            <td>
                                <strong>{{ $company->name }}</strong>
                            </td>
                            <td>{{ $company->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div style="display: flex; gap: 10px;">
                                    <!-- التصحيح هنا -->
                                    <a href="{{ route('admin.companies.edit', ['company' => $company->id]) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    
                                    <!-- وتصحيح هنا أيضاً -->
                                    <form action="{{ route('admin.companies.destroy', ['company' => $company->id]) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الشركة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #6b7280;">
                <i class="fas fa-building" style="font-size: 60px; margin-bottom: 20px;"></i>
                <h3>لا توجد شركات</h3>
                <p>لم يتم إضافة أي شركات حتى الآن.</p>
                <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> إضافة أول شركة
                </a>
            </div>
        @endif
    </div>
</div>
@endsection