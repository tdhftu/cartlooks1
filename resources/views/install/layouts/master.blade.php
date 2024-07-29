<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if (trim($__env->yieldContent('template_title')))
            @yield('template_title')
        @endif
    </title>
    <link rel="icon" type="image/png" href="{{ asset('public/web-assets/installer/img/favicon/favicon.png') }}"
        sizes="16x16" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="{{ asset('public/web-assets/installer/css/font-awsome/all.min.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('public/web-assets/installer/css/style.css') }}" rel="stylesheet" />
    <style>
        .fa-spinner {
            margin-left: 5px;
        }
    </style>
    @yield('style')
</head>

<body>
    <div class="master">
        <div class="box">
            <div class="header">
                <h1 class="header__title">@yield('title')</h1>
            </div>
            <ul class="step">
                <li class="step__divider"></li>
                <li class="step__item {{ Request::routeIs('install.user.registration') ? 'active ' : '' }}">
                    @if (Request::routeIs('install.user.registration'))
                        <a href="{{ route('install.user.registration') }}">
                            <span class="step__icon">
                                <i class="icofont-manage-user"></i>
                            </span>
                        </a>
                    @else
                        <i class="step__icon fa-solid fa-user"></i>
                    @endif
                </li>
                <li class="step__divider"></li>
                <li class="step__item {{ Request::routeIs('install.database.import') ? 'active ' : '' }}">
                    @if (Request::routeIs('install.user.registration') || Request::routeIs('install.database.import'))
                        <a href="{{ route('install.database.import') }}">
                            <i class="step__icon fa-solid fa-file-import"></i>
                        </a>
                    @else
                        <i class="step__icon fa-solid fa-file-import"></i>
                    @endif
                </li>
                <li class="step__divider"></li>
                <li class="step__item {{ Request::routeIs('install.database') ? 'active ' : '' }}">
                    @if (Request::routeIs('install.user.registration') ||
                            Request::routeIs('install.database') ||
                            Request::routeIs('install.database.import'))
                        <a href="{{ route('install.database') }}">
                            <i class="step__icon fa-solid fa-database"></i>
                        </a>
                    @else
                        <i class="step__icon fa-solid fa-database"></i>
                    @endif
                </li>
                <li class="step__divider"></li>
                <li class="step__item {{ Request::routeIs('install.permissions') ? 'active ' : '' }}">
                    @if (Request::routeIs('install.user.registration') ||
                            Request::routeIs('install.database') ||
                            Request::routeIs('install.permissions') ||
                            Request::routeIs('install.database.import'))
                        <a href="{{ route('install.permissions') }}">
                            <i class="step__icon fa-solid fa-key"></i>
                        </a>
                    @else
                        <i class="step__icon fa-solid fa-key"></i>
                    @endif
                </li>
                <li class="step__divider"></li>

                <li class="step__item {{ Request::routeIs('install.requirements') ? 'active ' : '' }}">
                    <a href="{{ route('install.requirements') }}">
                        <i class="step__icon fa-solid fa-list"></i>
                    </a>
                </li>
                <li class="step__divider"></li>

                <li class="step__item {{ Request::routeIs('install.welcome') ? 'active ' : '' }}">
                    <a href="{{ route('install.welcome') }}">
                        <i class="step__icon fa-solid fa-house"></i>
                    </a>
                </li>
                <li class="step__divider"></li>
            </ul>
            <div class="main">
                @if (session('message'))
                    <p class="alert text-center">
                        <strong>
                            @if (is_array(session('message')))
                                {{ session('message')['message'] }}
                            @else
                                {{ session('message') }}
                            @endif
                        </strong>
                    </p>
                @endif
                @yield('container')
            </div>
        </div>
    </div>
    <script src="{{ asset('/public/web-assets/backend/js/jquery.min.js') }}"></script>
    <script>
        var zyllemMain = (function() {
            function processSubmitLoader() {
                $('.process-btn').click(function(e) {
                    var $this = $(this);
                    let formId = $this.data("spinning-button");
                    let $form = formId ? $("#" + formId) : $this.parents("form");
                    if ($form.length) {
                        $this
                            .append("<i class='fa fa-spinner fa-spin'></i>")
                            .attr("disabled", "");
                        setTimeout(() => {
                            $form.submit();
                        }, 3000);
                    }
                });
            }
            return {
                initSpinnerButton: processSubmitLoader
            };
        })();

        $(document).ready(function() {
            zyllemMain.initSpinnerButton();
        });
    </script>
    @yield('scripts')
</body>

</html>
