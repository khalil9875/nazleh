@extends('layouts.app')

@section('content')
<div class="auth-container" style="margin-top:300px;">
    <div class="auth-form">
        <h2>Create Your Account</h2>
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <p class="auth-link">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>
@endsection