@extends('theme/cartlooks-theme::frontend.layouts.master')
@section('seo')
    <title>{{ translate('Login', session()->get('api_locale')) }}</title>
    <meta name="title" content="Login |" {{ getGeneralSetting('site_title') }} />
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
@endsection
