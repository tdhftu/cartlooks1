@extends('theme/cartlooks-theme::frontend.layouts.master')
@if ($shopDetails != null)
    @section('seo')
        <title>{{ $shopDetails->shop_name }}</title>
        <meta name="title"
            content="{{ $shopDetails->meta_title != null ? $shopDetails->meta_title : $shopDetails->shop_name }}" />
        <meta name="title"
            content="{{ $shopDetails->meta_title != null ? $shopDetails->meta_title : $shopDetails->shop_name }}" />
        <meta name="description"
            content="{{ $shopDetails->meta_description != null ? $shopDetails->meta_description : $shopDetails->shop_name }}" />
        <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title"
            content="{{ $shopDetails->meta_title != null ? $shopDetails->meta_title : $shopDetails->shop_name }}" />
        <meta property="og:description"
            content="{{ $shopDetails->meta_description != null ? $shopDetails->meta_description : $shopDetails->shop_name }}" />
        <meta name="twitter:card"
            content="{{ $shopDetails->meta_description != null ? $shopDetails->meta_description : $shopDetails->shop_name }}" />
        <meta name="twitter:title"
            content="{{ $shopDetails->meta_title != null ? $shopDetails->meta_title : $shopDetails->shop_name }}" />
        <meta name="twitter:description"
            content="{{ $shopDetails->meta_description != null ? $shopDetails->meta_description : $shopDetails->shop_name }}" />
        <meta name="twitter:image"
            content="{{ $shopDetails->meta_image != null ? getFilePath($shopDetails->meta_image, false) : '' }}" />
        <meta property="og:image"
            content="{{ $shopDetails->meta_image != null ? getFilePath($shopDetails->meta_image, false) : '' }}" />
    @endsection

@endif
