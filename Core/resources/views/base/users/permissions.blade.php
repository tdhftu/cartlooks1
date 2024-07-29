@extends('core::base.layouts.master')
@section('title')
    {{ translate('Permissions') }}
@endsection
@section('custom_css')
    <!-- ======= BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/public/web-assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/public/web-assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('/public/web-assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- ======= END BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
@endsection
@section('main_content')
    <div class="row">
        <!-- Permission List-->
        <div class="col-md-8 mx-auto">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <h4>{{ translate('Permissions') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="hoverable text-nowrap" id="permission_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Module Name') }} </th>
                                    <th>{{ translate('Permission Name') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $key = 1;
                                @endphp
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $permission->module_name }}</td>
                                        <td>{{ $permission->permission_name }}</td>
                                    </tr>
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Permission List-->
    </div>
@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/web-assets/backend/plugins/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/public/web-assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('/public/web-assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('/public/web-assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script>
        (function($) {
            "use strict";
            $("#permission_table").DataTable();
        })(jQuery);
    </script>
@endsection
