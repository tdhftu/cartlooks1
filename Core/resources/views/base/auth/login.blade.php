@php
    $admin_logo = getGeneralSetting('admin_dark_logo');
@endphp
@extends('core::base.auth.auth_layout')
@section('title')
    {{ translate('Login') }}
@endsection
@section('custom_css')
    <style>
        .login-page-layout {
            height: 100vh;
            background-image: url('/public/web-assets/backend/img/admin-log-in-bg.jpg');
            background-size: cover;
            min-height: 100%;
            background-repeat: no-repeat;
        }

        .card {
            border-radius: 4px !important;
        }

        .logo {
            min-height: 70px;
        }

        .container-fluid.login-page-layout:before {
            content: "";
            background-color: rgb(183 180 180 / 50%);
            top: 0;
            height: 100%;
            left: 0;
            width: 100%;
            position: absolute;
        }

        .text-darkest {
            color: #000
        }
    </style>
@endsection
@section('main_content')
    <div class="container-fluid login-page-layout position-relative">
        <div class="align-items-center h-100 justify-content-center row py-5">
            <div class="col-xl-3 col-lg-4  col-12 mx-auto">
                <div class="card text-white p-3 py-4 bg-custom">
                    <div class="auth-card-header text-center pt-3">
                        <div class="logo">
                            @if ($admin_logo != null)
                                <a href="/" class="default-logo">
                                    <img src="{{ getFilePath($admin_logo, false) }}"
                                        alt="{{ getGeneralSetting('system_name') }}">
                                </a>
                            @else
                                <h3 class="default-logo">{{ getGeneralSetting('system_name') }}</h3>
                            @endif
                        </div>
                        <h3 class="font-20 mb-2">Welcome Back </h3>
                        <p>Login to Admin Dashboard</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('core.attemptLogin') }}" method="post">
                            @csrf
                            <!-- Form Group -->
                            <div class="form-group mb-20">
                                <label for="email" class="mb-2 font-14 bold black">{{ translate('Email') }}</label>
                                <input type="email" id="email" name="email" class="theme-input-style text-darkest"
                                    placeholder="{{ translate('Email Address') }}" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="text-danger mt-2 font-12">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="form-group mb-20">
                                <label for="password" class="mb-2 font-14 bold black">{{ translate('Password') }}</label>
                                <input type="password" id="password" name="password" class="theme-input-style text-darkest"
                                    placeholder="{{ translate('********') }}">
                                @if ($errors->has('password'))
                                    <div class="text-danger mt-2 font-12">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                            <!-- End Form Group -->
                            <div class="form-row justify-content-between mb-20">
                                <a href="{{ route('core.password.reset.link') }}"
                                    class="font-12 text_color">{{ translate('Forgot Password?') }}
                                </a>
                            </div>
                            <div class="form-row">
                                <button type="submit" class="btn long w-100">{{ translate('Log In') }}</button>
                            </div>
                        </form>
                        @if (env('APP_DEMO') == true)
                            <div class="mt-4">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p class="mt-2 email-value">admin@example.com</p>
                                            </td>
                                            <td>
                                                <p class="mt-2 password-value">111111</p>
                                            </td>
                                            <td>
                                                <button class="btn btn-info sm auto-fill-btn">
                                                    <i class="icofont-copy-invert"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')
    <script>
        $(function($) {
            "use strict";
            $('.auto-fill-btn').on('click', function(e) {
                $("#email").val($('.email-value').html());
                $("#password").val($('.password-value').html());
            });
        });
    </script>
@endsection
