@extends('theme/cartlooks-theme::frontend.layouts.master')
@section('seo')
    @if ($blog_details != null)
        <title> {{ $blog_details->name }}</title>
        <meta name="title" content="{{ $blog_details->meta_title }}" />
        <meta name="description" content="{{ $blog_details->meta_description }}" />
        <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ $blog_details->meta_title }}" />
        <meta property="og:description" content="{{ $blog_details->meta_description }}" />
        <meta name="twitter:card" content="{{ $blog_details->meta_title }}" />
        <meta name="twitter:title" content="{{ $blog_details->meta_title }}" />
        <meta name="twitter:description" content="{{ $blog_details->meta_description }}" />
        <meta name="twitter:image" content="{{ $blog_details->meta_image }}" />
        <meta property="og:image" content="{{ $blog_details->meta_image }}" />
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
