@extends('theme/cartlooks-theme::frontend.layouts.master')
@section('seo')
    <title> {{ $deals_details->translation('title', session()->get('api_locale')) }}</title>
    <meta name="title" content="{{ $deals_details->meta_title }}" />
    <meta name="description" content="{{ $deals_details->meta_description }}" />
    <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $deals_details->meta_title }}" />
    <meta property="og:description" content="{{ $deals_details->meta_description }}" />
    <meta name="twitter:card" content="{{ $deals_details->meta_title }}" />
    <meta name="twitter:title" content="{{ $deals_details->meta_title }}" />
    <meta name="twitter:description" content="{{ $deals_details->meta_description }}" />
    <meta name="twitter:image" content="{{ $deals_details->meta_image }}" />
    <meta property="og:image" content="{{ $deals_details->meta_image }}" />
    <meta property="og:image:width" content="1200" />
@endsection
