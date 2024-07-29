<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Page Title -->
    <title>{{ translate('Welcome') }}</title>

    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../../assets/img/favicon.png">

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
</head>

<body>

    <div class="mn-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="bg-white col-12 col-lg-7 col-xl-6 p-4">
                    <div class="welcome-success">
                        <h3 class="text-center mb-2">Congratulation !!!</h3>
                        <p class="text-center">You have successfully activated your license.</p>
                        <div class="property-list">
                            <div class="list-header">
                                <h4>Configure the following settings to run the system property</h4>
                            </div>
                            <div class="list-item mt-10">
                                <ul class="mb-0">
                                    <li class="mb-1">
                                        <a href="{{ route('core.email.smtp.configuration') }}" target="_blank">
                                            SMTP Settings
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('plugin.cartlookscore.ecommerce.configuration') }}"
                                            target="_blank">
                                            Ecommerce Settings
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('core.general.settings') }}" target="_blank">
                                            General Settings
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('plugin.cartlookscore.shipping.configuration') }}"
                                            target="_blank">
                                            Shipping & Delivery Settings
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('plugin.cartlookscore.ecommerce.settings.taxes.list') }}"
                                            target="_blank">
                                            Tax Settings
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('core.languages') }}" target="_blank">
                                            Language Settings
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex gap-15 justify-content-center welcome-footer mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary rounded">Visit Admin
                                Dashboard</a>
                            <a href="/" class="btn btn-success rounded">Visit Frontend</a>
                        </div>
                    </div>
                </div>
            </div>
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
