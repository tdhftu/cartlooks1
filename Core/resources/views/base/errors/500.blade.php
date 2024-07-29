<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Page Title -->
    <title>Error Page</title>

    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/public/web-assets/backend/img/favicon.png') }}">

    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">

    <!-- ======= BEGIN GLOBAL MANDATORY STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/fonts/icofont/icofont.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/public/web-assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }}">
    <!-- ======= END BEGIN GLOBAL MANDATORY STYLES ======= -->

    <!-- ======= MAIN STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/css/style.css') }}">
    <!-- ======= END MAIN STYLES ======= -->
</head>

<body>
    <div class="mn-vh-100 d-flex align-items-center mx-1350">
        <div class="container-fluid">
            <!-- Card -->
            <div class="card justify-content-center py-5 px-4">
                <div class="row justify-content-center my-5 pt-4">
                    <div class="col-xl-12 text-center">
                        <h1 class="mb-20">{{ $title }}</h1>
                        <p class="mxw-550">{{ $message }}</p>
                        <div class="mt-3 mb-30 pb-2">
                            <a href="{{ $route }}" class="details-btn">
                                Back To Home
                                <img src="{{ asset('/public/web-assets/backend/img/svg/left-arrow-c2.svg') }}"
                                    alt="" class="svg">
                            </a>
                        </div>

                        <img src="{{ asset('/public/web-assets/backend/img/media/error5.png') }}" alt="">
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
    <script src="{{ asset('/public/web-assets/backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/js/script.js') }}"></script>
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
</body>

</html>
