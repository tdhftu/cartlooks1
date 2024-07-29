@extends('theme/cartlooks-theme::frontend.layouts.master')
@section('seo')
    @if ($product_details != null)
        <title> {{ $product_details->translation('name', session()->get('api_locale')) }}</title>
        <meta name="title"
            content="{{ $product_details->meta_title != null ? $product_details->meta_title : $product_details->name }}" />
        <meta name="description"
            content="{{ $product_details->meta_description != null ? $product_details->meta_description : $product_details->name }}" />
        <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title"
            content="{{ $product_details->meta_title != null ? $product_details->meta_title : $product_details->name }}" />
        <meta property="og:description"
            content="{{ $product_details->meta_description != null ? $product_details->meta_description : $product_details->name }}" />
        <meta name="twitter:card"
            content="{{ $product_details->meta_title != null ? $product_details->meta_title : $product_details->name }}" />
        <meta name="twitter:title"
            content="{{ $product_details->meta_title != null ? $product_details->meta_title : $product_details->name }}" />
        <meta name="twitter:description"
            content="{{ $product_details->meta_description != null ? $product_details->meta_description : $product_details->name }}" />
        <meta name="twitter:image" content="{{ $product_details->meta_image }}" />
        <meta property="og:image" content="{{ $product_details->meta_image }}" />
        <meta property="og:image:width" content="1200" />
    @else
        <title>{{ getGeneralSetting('site_title') }}</title>
        <meta name="title" content="{{ getGeneralSetting('site_meta_title') }}" />
        <meta name="description" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ getGeneralSetting('site_meta_title') }}" />
        <meta property="og:description" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="twitter:card" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="twitter:title" content="{{ getGeneralSetting('site_meta_title') }}" />
        <meta name="twitter:description" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="twitter:image" content="{{ getFilePath(getGeneralSetting('site_meta_image'), false) }}" />
        <meta property="og:image" content="{{ getFilePath(getGeneralSetting('site_meta_image'), false) }}" />
    @endif
@endsection
