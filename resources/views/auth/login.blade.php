@extends('layouts.app')

@section('content')
<div class="auth-container" style="margin-top:300px;">
    <div class="auth-form">
        <h2>Login to Your Account</h2>
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group remember">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="auth-link">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
    </div>
</div>
@endsection