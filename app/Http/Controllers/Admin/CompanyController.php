<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    private function ensureDirectoryExists()
    {
        $directory = public_path('images/companies');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    public function index()
    {
        $companies = Company::latest()->get();
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $this->ensureDirectoryExists();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $logoName = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/companies'), $logoName);
        }

        Company::create([
            'name' => $request->name,
            'logo' => $logoName
        ]);

        return redirect()->route('admin.companies.index')
            ->with('success', 'تم إضافة الشركة بنجاح');
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $this->ensureDirectoryExists();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $logoName = $company->logo;
        
        if ($request->hasFile('logo')) {
            // حذف الصورة القديمة
            if ($company->logo && file_exists(public_path('images/companies/' . $company->logo))) {
                File::delete(public_path('images/companies/' . $company->logo));
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/companies'), $logoName);
        }

        $company->update([
            'name' => $request->name,
            'logo' => $logoName
        ]);

        return redirect()->route('admin.companies.index')
            ->with('success', 'تم تحديث بيانات الشركة بنجاح');
    }

    public function destroy(Company $company)
    {
        if ($company->logo && file_exists(public_path('images/companies/' . $company->logo))) {
            File::delete(public_path('images/companies/' . $company->logo));
        }

        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', 'تم حذف الشركة بنجاح');
    }
}