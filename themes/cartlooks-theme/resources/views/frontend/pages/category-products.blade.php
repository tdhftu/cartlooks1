@extends('theme/cartlooks-theme::frontend.layouts.master')
@section('seo')
    <title> {{ $category_details->translation('name', session()->get('api_locale')) }}</title>
    <meta name="title" content="{{ $category_details->meta_title }}" />
    <meta name="description" content="{{ $category_details->meta_description }}" />
    <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $category_details->meta_title }}" />
    <meta property="og:description" content="{{ $category_details->meta_description }}" />
    <meta name="twitter:card" content="{{ $category_details->meta_title }}" />
    <meta name="twitter:title" content="{{ $category_details->meta_title }}" />
    <meta name="twitter:description" content="{{ $category_details->meta_description }}" />
    <meta name="twitter:image" content="{{ $category_details->meta_image }}" />
    <meta property="og:image" content="{{ $category_details->meta_image }}" />
    <meta property="og:image:width" content="1200" />
@endsection
