@php
    $accpt_update = true;
    $system_current_version = systemCurrentVersion();
    $mysqlVersion = DB::select('select version() as version')[0]->version;
    
    $required_post_max_size = 200;
    $post_max_size = substr(ini_get('post_max_size'), 0, -1);
    if ($post_max_size < $required_post_max_size) {
        $accpt_update = false;
    }
    
    $required_upload_max_filesize = 200;
    $upload_max_filesize = substr(ini_get('upload_max_filesize'), 0, -1);
    if ($upload_max_filesize < $required_upload_max_filesize) {
        $accpt_update = false;
    }
    
    if (!is_writable(storage_path())) {
        $accpt_update = false;
    }
    
@endphp
@extends('core::base.layouts.master')
@section('title')
    {{ translate('Update System') }}
@endsection
@section('custom_css')
    <style>
        .update-submit-btn {
            text-decoration: none;
            padding: 10px 20px;
            background: tomato;
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
    <div class="row">
        <div class="col-lg-7 mb-30">
            <!--System Status-->
            <div class="card">
                <div class="align-items-center bg-white card-header d-flex justify-content-between py-3">
                    <h4>{{ translate('System & Server Information') }}</h4>
                </div>
                <div class="card-body p-0">
                    <table class="text-nowrap bg-white dh-table">
                        <tbody>
                            <tr>
                                <td>System Current Version</td>
                                <td class="text-right">
                                    {{ $system_current_version }}
                                </td>
                            </tr>
                            <tr>
                                <td>PHP Version</td>
                                <td class="text-right">
                                    {{ phpversion() }}
                                </td>
                            </tr>
                            <tr>
                                <td>MySQL</td>
                                <td class="text-right">
                                    {{ $mysqlVersion }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--End System Status-->
            <!--Php Config-->
            <div class="card mt-20">
                <div class="align-items-center bg-white card-header d-flex justify-content-between py-3">
                    <h4>php.ini {{ translate('Config') }}</h4>
                </div>
                <div class="card-body p-0">
                    <table class="text-nowrap bg-white dh-table">
                        <thead>
                            <tr>
                                <th>{{ translate('Config Name') }}</th>
                                <th>{{ translate('Current') }}</th>
                                <th>{{ translate('Recommended') }}</th>
                                <th class="text-right">{{ translate('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>max_file_uploads</td>
                                <td>{{ ini_get('max_file_uploads') }}</td>
                                <td>20</td>
                                <td class="text-right">
                                    @if (ini_get('max_file_uploads') >= 20)
                                        <i class="icofont-check-alt text-success"></i>
                                    @else
                                        <i class="icofont-close-line text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>upload_max_filesize</td>
                                <td>{{ ini_get('upload_max_filesize') }}</td>
                                <td>{{ $required_upload_max_filesize }}M</td>
                                <td class="text-right">
                                    @if ($upload_max_filesize >= $required_upload_max_filesize)
                                        <i class="icofont-check-alt text-success"></i>
                                    @else
                                        <i class="icofont-close-line text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>post_max_size</td>
                                <td>{{ ini_get('post_max_size') }}</td>
                                <td>{{ $required_post_max_size }}M</td>
                                <td class="text-right">
                                    @if ($post_max_size >= $required_post_max_size)
                                        <i class="icofont-check-alt text-success"></i>
                                    @else
                                        <i class="icofont-close-line text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--End Php Config-->
            <!--File System Permission-->
            <div class="card mt-20">
                <div class="align-items-center bg-white card-header d-flex justify-content-between py-3">
                    <h4>{{ translate('Filesystem Permissions') }}</h4>
                </div>
                <div class="card-body p-0">
                    <table class="text-nowrap bg-white dh-table">
                        <thead>
                            <tr>
                                <th>{{ translate('File or Folder') }}</th>
                                <th class="text-right">{{ translate('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>storage</td>
                                <td class="text-right">
                                    @if (is_writable(storage_path()))
                                        <i class="icofont-check-alt text-success"></i>
                                    @else
                                        <i class="icofont-close-line text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>themes</td>
                                <td class="text-right">
                                    @if (is_writable(base_path('themes')))
                                        <i class="icofont-check-alt text-success"></i>
                                    @else
                                        <i class="icofont-close-line text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>plugins</td>
                                <td class="text-right">
                                    @if (is_writable(base_path('plugins')))
                                        <i class="icofont-check-alt text-success"></i>
                                    @else
                                        <i class="icofont-close-line text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Core</td>
                                <td class="text-right">
                                    @if (is_writable(base_path('Core')))
                                        <i class="icofont-check-alt text-success"></i>
                                    @else
                                        <i class="icofont-close-line text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--End Filesystem Permission-->
        </div>
        <!--System Updater-->
        <div class="col-lg-5 mb-30">
            <div class="card">
                <div class="align-items-center bg-white card-header py-3">
                    <h4>{{ translate('System Update') }}</h4>

                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p class="mb-1">{{ translate('Please backup your files and database before update.') }}</p>
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

                    <form method="POST" action="{{ route('app.system.update.file.submit') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-row mb-20">
                            <label>{{ translate('Update Zip File') }}</label>
                            <input type="file" id="id" name="update_file"
                                class="form-control-file theme-input-style">
                            @if ($errors->has('update_file'))
                                <div class="invalid-input">{{ $errors->first('update_file') }}</div>
                            @endif
                        </div>
                        @if ($upload_max_filesize < $required_upload_max_filesize)
                            <p class="alert alert-danger">1. Please make sure, your server php "upload_max_filesize" value
                                is
                                grater
                                or equal to 200M. Current value is - {{ $upload_max_filesize }}M
                            </p>
                        @endif
                        @if ($post_max_size < $required_post_max_size)
                            <p class="alert alert-danger">2. Please make sure, your server php "post_max_size" value is
                                grater
                                or
                                equal to 250M. Current value is - {{ $post_max_size }}M
                            </p>
                        @endif
                        @if ($accpt_update)
                            <div class="float-right form-row">
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
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <!--End System Updater-->
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
