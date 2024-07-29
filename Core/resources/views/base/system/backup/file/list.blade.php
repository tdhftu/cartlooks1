@extends('core::base.layouts.master')
@section('title')
    {{ translate('Files Backup') }}
@endsection
@section('custom_css')
    <style>
        .backup-generate-btn {
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
        <div class="col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    @include('core::base.system.backup.includes.tabs')
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade {{ Request::routeIs(['core.backup.files.list']) ? ' show active' : '' }}">
                            <div class="table-responsive">
                                <a href="{{ route('core.backup.files.generate') }}"
                                    class="btn float-right mb-10 rounded sm backup-generate-btn">
                                    <span
                                        class="backup-generate-btn-label">{{ translate('Generate Project Backup') }}</span>
                                    <div class="spinner">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </a>
                                <table id="example" class="hoverable text-nowrap border-top2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('File') }}</th>
                                            <th>{{ translate('Create Date') }}</th>
                                            <th>{{ translate('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (\File::exists(storage_path('app/backups/files')))
                                            @php
                                                $files = \File::files(storage_path('app/backups/files'));
                                            @endphp
                                            @if (sizeOf($files) > 0)
                                                @foreach ($files as $key => $path)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            {{ pathinfo($path)['basename'] }}
                                                            @if (pathinfo($path)['extension'] != 'zip')
                                                                <span
                                                                    class="badge badge-danger">{{ translate('Unhealthy') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $name = pathinfo($path)['filename'];
                                                                $name_array = explode('_', $name);
                                                                
                                                            @endphp
                                                            {{ $name_array[3] . '-' . $name_array[2] . '-' . $name_array[1] }}
                                                        </td>
                                                        <td>
                                                            <div class="dropdown-button">
                                                                <a href="#"
                                                                    class="d-flex align-items-center justify-content-end"
                                                                    data-toggle="dropdown">
                                                                    <div class="menu-icon mr-0">
                                                                        <span></span>
                                                                        <span></span>
                                                                        <span></span>
                                                                    </div>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a
                                                                        href="{{ route('core.backup.files.download', ['filename' => pathinfo($path)['basename']]) }}">
                                                                        {{ translate('Download') }}
                                                                    </a>
                                                                    <a href="#"
                                                                        data-name="{{ pathinfo($path)['basename'] }}"
                                                                        class="delete-backup">
                                                                        {{ translate('Delete') }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">
                                                        <p class="alert alert-danger text-center">
                                                            {{ translate('No backup file found') }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    <p class="alert alert-danger text-center">
                                                        {{ translate('No backup file found') }}</p>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!--Delete Modal-->
<div id="delete-modal" class="delete-modal modal fade show" aria-modal="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                <form method="POST" action="{{ route('core.backup.files.delete') }}">
                    @csrf
                    <input type="hidden" id="filename" name="filename">
                    <button type="button" class="btn long mt-2 btn-danger"
                        data-dismiss="modal">{{ translate('cancel') }}</button>
                    <button type="submit" class="btn long mt-2">{{ translate('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Delete Modal-->
@section('custom_scripts')
    <script type="application/javascript">
        (function($) {
            "use strict";
           /**
            * Delete backup
            **/
           $('.delete-backup').on('click',function(e){
             e.preventDefault();
             let name=$(this).data('name');
                $("#filename").val(name);
                $('#delete-modal').modal('show');
           });
           /**
            * Backup generate btn
            **/
           $('.backup-generate-btn').on('click',function(e){
                window.close();
                $(".backup-generate-btn-label").text("Please wait");
                $('.spinner').addClass("lds-ellipsis");
           });
        })(jQuery);
    </script>
@endsection
