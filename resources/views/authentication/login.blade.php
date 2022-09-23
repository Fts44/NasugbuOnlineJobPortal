@extends('layout.authentication')

@push('title')
    <title>Login</title>
@endpush

@push('css')
    
@endpush

@section('content')
    <form action="" class="theme-form login-form">

        <h4>Nasugbueños: O-JoFi</h4>

        <h6 style="font-size: 13px;">
            An Online Job Finder Platform Exclusive for Nasugbueños.
        </h6>
        
        <div class="form-group">
            <label>Email Address:</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input class="form-control" type="email" required="">
            </div>
        </div>

        <div class="form-group mb-2">
            <label>Password:</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input class="form-control" type="password" id="password" required="">

                <span class="input-group-text">
                    <i class="fa-solid fa-eye d-none" id="password_show" style="cursor: pointer;"></i>
                    <i class="fa-solid fa-eye-slash" id="password_hide" style="cursor: pointer;"></i>
                </span>
            </div>
        </div>

        <div class="form-group row mb-4 text-end">
            <a class="link" href="{{ route('forgot-password') }}">Forgot password?</a>
        </div>

        <div class="form-group text-start">
            <button class="btn btn-primary" type="submit">Sign in</button>
        </div>

        <div class="form-group mb-0">
            <p>Don't have account?
                <a class="ms-2" href="{{ route('register') }}">Create Account</a>
            </p>
        </div>
    </form>
@endsection

@push('script')

@endpush
