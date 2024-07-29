@extends('core::base.auth.auth_layout')
@section('title')
    {{ translate('Update System') }}
@endsection
@section('custom_css')
    <style>
        .update-submit-btn {
            text-decoration: none;
            padding: 10px 20px;
            display: inline-flex !important;
            align-items: center;
            margin: 0;
            color: white;
        }

        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 70px;
            height: 13px;
        }

        .lds-ellipsis div {
            position: absolute;
            top: 0px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #fff;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .lds-ellipsis div:nth-child(1) {
            left: 8px;
            animation: lds-ellipsis1 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(2) {
            left: 8px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(3) {
            left: 32px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(4) {
            left: 56px;
            animation: lds-ellipsis3 0.6s infinite;
        }

        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(0);
            }
        }

        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(24px, 0);
            }
        }
    </style>
@endsection
@section('main_content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-6 mb-30 mx-auto">
                <div class="card">
                    <div class="align-items-center bg-white card-header py-3">
                        <h4>{{ translate('System Update') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <p class="mb-1">{{ translate('Please backup your files and database before update.') }}
                            </p>
                            <ul class="mb-0">
                                <li>
                                    <p class="font-13 mb-0">
                                        <a href="{{ route('core.backup.files.list') }}"
                                            class="btn-link">{{ translate('Generate File Backup') }}
                                        </a>
                                    </p>
                                </li>
                                <li>
                                    <p class="font-13 mb-0">
                                        <a href="{{ route('core.backup.database.list') }}"
                                            class="btn-link">{{ translate('Generate Database Backup') }}
                                        </a>
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <p class="alert alert-danger d-none alert-message">
                            <i class="icofont-warning"></i>
                            {{ translate('Do not reload or close tab while updating. It may takes some times') }}
                        </p>

                        <form method="POST" action="{{ route('app.system.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row justify-content-between">
                                <a href="{{ route('app.system.update.cancel') }}" class="btn rounded btn-danger text-white">
                                    {{ translate('Cancel Update') }}
                                </a>

                                <button class="btn rounded update-submit-btn" type="submit">
                                    <span class="update-submit-btn-label">{{ translate('Update Now') }}</span>
                                    <div class="spinner">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script type="application/javascript">
        (function($) {
            "use strict";
            /**
            * Update btn
            **/
           $('.update-submit-btn').on('click',function(e){
            $(".alert-message").removeClass('d-none');
            $(".update-submit-btn-label").text("Please wait");
                $('.spinner').addClass("lds-ellipsis");
           });
        })(jQuery);
    </script>
@endsection
