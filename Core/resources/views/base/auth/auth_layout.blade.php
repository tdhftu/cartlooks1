@php
    $settings_details = getGeneralSettingsDetails();
@endphp
<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Page Title -->

    <title>
        @yield('title')
    </title>

    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    @if (isset($logo_details['favicon']))
        <link rel="shortcut icon" href="{{ project_asset($logo_details['favicon']) }}">
    @else
        <link rel="shortcut icon" href="{{ asset('/public/web-assets/backend/img/favicon.png') }}">
    @endif
    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">

    <!-- ======= BEGIN GLOBAL MANDATORY STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/fonts/icofont/icofont.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/public/web-assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }}">
    <!-- ======= END BEGIN GLOBAL MANDATORY STYLES ======= -->

    <!-- ======= MAIN STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/css/light/style.css') }}">
    <!-- ======= END MAIN STYLES ======= -->

    <!-- ======= TOASTER CSS======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/css/toaster.min.css') }}">
    <!-- ======= TOASTER CSS======= -->
    @yield('custom_css')
</head>

<body>

    @yield('main_content')
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
    <script src="{{ asset('/public/web-assets/backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/js/script.js') }}"></script>
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->

    <!-- ======= TOASTER ======= -->
    <script src="{{ asset('/public/web-assets/backend/js/toaster.min.js') }}"></script>
    {!! Toastr::message() !!}
    <!-- ======= TOASTER ======= -->
    @yield('custom_scripts')
</body>

</html>
