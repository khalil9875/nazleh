<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
class AuthController extends Controller
{
    // عرض نموذج تسجيل الدخول
    public function showLoginForm()
    {
        $companies=Company::all();
        return view('auth.login',compact('companies'));
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // التحقق مما إذا كان المستخدم مديراً
            if (Auth::user()->is_admin) {
                return redirect()->route('dashboard'); // توجيه إلى لوحة تحكم المدير
            }
            
            return redirect()->intended('/'); // توجيه إلى الصفحة الرئيسية للمستخدمين العاديين
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }

    // عرض نموذج التسجيل
    public function showRegisterForm()
    {
                $companies=Company::all();

        return view('auth.register',compact('companies'));
    }

    // معالجة التسجيل
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false, // تأكد من تعيين false كقيمة افتراضية للمستخدمين الجدد
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Account created successfully!');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}