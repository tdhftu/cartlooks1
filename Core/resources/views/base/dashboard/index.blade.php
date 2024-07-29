@extends('core::base.layouts.master')
@section('title')
    {{ translate('Dashboard') }}
@endsection
@section('custom_css')
    <!-- ======= BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/apex/apexcharts.css') }}">
    <!-- ======= END BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
@endsection

@section('main_content')
    @if (collect(getActivePluginDashboard())->count() > 0)
        @foreach (collect(getActivePluginDashboard()) as $item)
            @includeIf($item)
        @endforeach
    @else
        <h1>Core Dashboard</h1>
    @endif
@endsection

@section('custom_scripts')
    <!-- ======= BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <script src="{{ asset('/public/web-assets/backend/plugins/apex/apexcharts.min.js') }}"></script>
    <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
@endsection
