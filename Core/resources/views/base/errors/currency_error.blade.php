@extends('core::base.errors.error_master')
@section('error_title')
    {{ translate('Currency error') }}
@endsection
@section('error_master')
    <h5 class="mxw-550 mb-30">{{ $message }}</h5>
    <img src="{{ asset('/public/web-assets/backend/img/error.png') }}" alt="Currency error">
@endsection
