{{-- Extends layout --}}
@extends('layout.fullwidth')



{{-- Content --}}
@section('content')
    <div class="col-md-6">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            <img src="images/logo-full-black.png" alt="">
                        </div>
                        <h4 class="text-center mb-4">Sign in your account</h4>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label class="mb-1"><strong>Username</strong></label>
                                <input id="username" name="username" type="text" class="form-control"
                                    placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label class="mb-1"><strong>Password</strong></label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Password">
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox ms-1">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <div class="mt-2 text-sm text-danger">
                                @error('username')
                                    <p>{{ $message }}</p>
                                @enderror

                                @error('password')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </form>
                        {{-- <div class="new-account mt-3">
                            <p>Don't have an account? <a class="text-primary" href="{!! url('/page-register') !!}">Sign
                                    up</a></p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
