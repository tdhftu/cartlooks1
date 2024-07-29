@php

    $report_repository = new Plugin\CartLooksCore\Repositories\ReportRepository();
    $business_stats = $report_repository->sellerBusinessStats();

    $recent_orders_query = \Plugin\CartLooksCore\Models\Orders::with([
        'customer_info',
        'guest_customer',
        'products' => function ($query) {
            $query->where('seller_id', auth()->user()->id)->select('order_id', 'seller_id', 'quantity', 'delivery_cost', 'unit_price', 'tax');
        },
    ])
        ->select('order_code', 'id', 'created_at', 'total_payable_amount', 'customer_id')
        ->orderBy('id', 'DESC');

    $recent_orders_query = $recent_orders_query->whereHas('products', function ($q) {
        $q->where('seller_id', auth()->user()->id);
    });
    $recent_orders = $recent_orders_query->take(6)->get();

    $top_products = \Plugin\CartLooksCore\Models\Product::select(['id', 'name', 'permalink', 'thumbnail_image'])
        ->where('supplier', auth()->user()->id)
        ->withCount(['orders'])
        ->withSum('orders', 'unit_price')
        ->withSum('orders', 'quantity')
        ->orderBy('orders_sum_quantity', 'DESC')
        ->take(5)
        ->get();

@endphp
@extends('plugin/multivendor-cartlooks::seller.dashboard.layouts.seller_master')
@section('title')
    {{ translate('Dashboard') }}
@endsection
@push('head')
    <!-- ======= BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/apex/apexcharts.css') }}">
    <!-- ======= END BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
    <style>
        .overflow-text {
            display: block;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dash-image {
            min-width: 60px !important;
        }

        .order-couter-item {
            padding: 13px 0px;
        }

        .apexcharts-toolbar {
            top: -46px !important;
        }

        .img-20 {
            width: 20px !important;
            height: 20px !important;
        }

        .fixed-card {
            max-height: 490px !important;
            min-height: 490px !important;
        }

        .color-icon {
            color: #f53b22;
        }

        .custom-card {
            border: 1px solid rgba(180, 208, 224, .5) !important;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .05) !important;
            transition: all .3s ease !important;
        }
    </style>
@endpush

@section('seller_main_content')
    <!--Business Stats-->
    <div class="card mb-30">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4>{{ __('Business Insight') }}</h4>
            <div class="section-box">
                <select class="form-control" id="business_insight_change">
                    <option value="over_all">{{ translate('Overall statistics') }}</option>
                    <option value="today">{{ translate('Todays Statistics') }}</option>
                    <option value="month">{{ translate('This Months Statistics') }}</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!--Total Products-->
                <div class="col-xl-3 col-sm-6">
                    <div class="card custom-card mb-20">
                        <div class="state">
                            <div class="d-flex justify-content-between px-2">
                                <div class="state-content bold black">
                                    <p class="font-14 mb-2">{{ translate('Total Products') }}</p>
                                    <h3 class="total_products">{{ $business_stats['total_products'] }}</h3>
                                </div>
                                <i class="icofont-bucket1 font-40 color-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Products-->
                <!--Total Orders-->
                <div class="col-xl-3 col-sm-6">
                    <div class="card custom-card mb-20">
                        <div class="state">
                            <div class="d-flex justify-content-between px-2">
                                <div class="state-content ">
                                    <p class="font-14 mb-2 bold black">{{ translate('Total Orders') }}</p>
                                    <h3 class="total_orders">
                                        {{ $business_stats['total_orders'] }}
                                    </h3>
                                </div>
                                <i class="icofont-chart-histogram-alt font-40 color-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End total Orders-->

                <!--Total Sales-->
                <div class="col-xl-3 col-sm-6">
                    <div class="card custom-card mb-20">
                        <div class="state">
                            <div class="d-flex justify-content-between px-2">
                                <div class="state-content">
                                    <p class="font-14 mb-2 black bold">{{ translate('Total Sales') }}</p>
                                    <h3 class="total_sales">{{ $business_stats['total_sales'] }}</h3>
                                </div>
                                <i class="icofont-money font-40 color-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Total Earning-->
                <div class="col-xl-3 col-sm-6">
                    <div class="card custom-card mb-20">
                        <div class="state">
                            <div class="d-flex justify-content-between px-2">
                                <div class="state-content bold black">
                                    <p class="font-14 mb-2">{{ translate('Total Eerning') }}</p>
                                    <h3 class="total_earning">{{ $business_stats['total_earning'] }}</h3>
                                </div>
                                <i class="icofont-money-bag font-40 color-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End earnung-->
                <!--End total Sales-->

                {{-- Order Summary  --}}

                <!-- Pendig Order -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-list font-20 color-icon"></i>
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Pending') }}</h5>
                                    </div>
                                </div>
                                <div class="">
                                    <h5 class="pending_orders">
                                        {{ $business_stats['pending_orders'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Pending Order -->

                <!-- approved Order -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-tick-boxed font-20 color-icon"></i>
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Approved') }}</h5>
                                    </div>
                                </div>
                                <div class="">
                                    <h5 class="approved">
                                        {{ $business_stats['approved'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End approved Order -->

                <!-- ready_to_ship Order -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-box font-20 color-icon"></i>
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Ready to Ship') }}</h5>
                                    </div>
                                </div>
                                <div class="">
                                    <h5 class="ready_to_ship">
                                        {{ $business_stats['ready_to_ship'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End ready_to_ship Order -->

                <!-- Shipped Order -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-fast-delivery font-20 color-icon"></i>
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Shipped') }}</h5>
                                    </div>
                                </div>
                                <div class="">
                                    <h5 class="shipped-order">
                                        {{ $business_stats['shipped'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End shipped order -->

                <!-- delivered Order -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-tick-mark font-20 color-icon"></i>
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Delivered') }}</h5>
                                    </div>
                                </div>
                                <div class="">
                                    <h5 class="delivered-order">
                                        {{ $business_stats['delivered'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End delivered order -->

                <!-- cancelled order -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-close font-20 color-icon"></i>
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Cancelled') }}</h5>
                                    </div>
                                </div>
                                <div class="">
                                    <h5 class="cancelled-order">
                                        {{ $business_stats['cancelled'] }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End cancelled order -->

                <!--total_refunds -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-reply font-20 color-icon"></i>
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Returned') }}</h5>
                                    </div>
                                </div>
                                <h5 class="total_refunds">
                                    {{ $business_stats['total_refunds'] }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End total_refunds -->

                <!-- return_processing -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-20 custom-card">
                        <div class="card-body p-2 px-3">
                            <div class="align-items-center  d-flex justify-content-between  order-couter-item">
                                <div class="d-flex align-items-center">
                                    <div class="img mr-3">
                                        <i class="icofont-match-review font-20 color-icon"></i>
                                        {{-- <i class="icofont-close font-20 color-icon"></i> --}}
                                    </div>
                                    <div class="content">
                                        <h5>{{ translate('Refund Processing') }}</h5>
                                    </div>
                                </div>
                                <h5 class="return_processing">
                                    {{ $business_stats['return_processing'] }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- return_processing -->

                {{-- End Order Summary --}}
            </div>
        </div>
    </div>
    <!--End Business Stats-->

    <div class="row">
        <!--Sales Reports-->
        <div class="col-xl-12 col-12">
            <div class="card mb-30">
                <div
                    class="card-header bg-white py-3 d-flex justify-content-start justify-content-sm-between align-items-start align-items-sm-center flex-column flex-sm-row mb-sm-n3  ">
                    <div class="title-content mb-4 mr-sm-5 mb-sm-0">
                        <h4 class="">{{ translate('Sale Reports') }}</h4>
                    </div>
                    <!-- List Button -->
                    <ul class="list-inline list-button m-0 mr-5">
                        <li class="active chart-switcher rounded" data-type="monthly">{{ translate('Last 12 Months') }}
                        </li>
                        <li class="chart-switcher rounded" data-type="daily">{{ translate('Last 30 Days') }}</li>
                    </ul>
                    <!-- End List Button -->
                </div>
                <div class="card-body">
                    <div id="apex_sales_report_chart"></div>
                </div>
            </div>
        </div>
        <!--End Sales Reports-->

        <!--Recent Orders-->
        <div class="col-xl-8 col-lg-7 col-12">
            <!-- Card -->
            <div class="card fixed-card mb-20">
                <div class="card-header bg-white py-3">
                    <h4>{{ translate('Recent Orders') }}</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="style--three table-centered text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ translate('Order ID') }}</th>
                                    <th>{{ translate('Date') }}</th>
                                    <th>{{ translate('Customer') }}</th>
                                    <th>{{ translate('Total Amount') }}</th>
                                    <th>{{ translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($recent_orders->count() > 0)
                                    @foreach ($recent_orders as $order)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route('plugin.multivendor.seller.dashboard.order.details', ['id' => $order->id]) }}">{{ $order->order_code }}</a>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
                                            <td>
                                                @if ($order->customer_info != null)
                                                    <p>{{ $order->customer_info->name }}</p>
                                                @else
                                                    <p>{{ $order->guest_customer->name }}
                                                        <span
                                                            class="badge badge-info ml-1">{{ translate('Guest') }}</span>
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $total_payable_amount = 0;
                                                    foreach ($order->products as $product) {
                                                        $total_payable_amount = $total_payable_amount + $product->totalPayableAmount();
                                                    }
                                                @endphp
                                                {!! currencyExchange($total_payable_amount) !!}
                                            </td>
                                            <td>
                                                <a href="{{ route('plugin.multivendor.seller.dashboard.order.details', ['id' => $order->id]) }}"
                                                    class="details-btn">
                                                    Details
                                                    <i class="icofont-arrow-right"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            <p class="alert alert-danger text-center">{{ translate('No Items Found') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- End Card -->
        </div>
        <!--End recents orders-->
        <!--Top Products-->
        <div class="col-xl-4 col-lg-6">
            <!-- Card -->
            <div class="card fixed-card mb-20">
                <div class="card-header bg-white py-3">
                    <h4>{{ translate('Top Products') }}</h4>
                </div>
                <div class="card-body pb-2">
                    <div class="product-list">
                        @if ($top_products->count() > 0)
                            @foreach ($top_products as $product)
                                <div class="product-list-item mb-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="img mr-3">
                                            <img src="{{ asset(getFilePath($product->thumbnail_image, true)) }}"
                                                alt="{{ $product->translation('name', getLocale()) }}"
                                                class="dash-image">
                                        </div>
                                        <div class="content">
                                            <p class="black mb-1 overflow-text text-capitalize">
                                                {{ $product->translation('name', getLocale()) }}</p>
                                            <span class="bold font-14">{!! currencyExchange($product->orders_sum_unit_price * $product->orders_sum_quantity) !!}</span>
                                        </div>
                                    </div>
                                    <p class="bold  font-14 text-center">
                                        {{ $product->orders_count != null ? $product->orders_count : 0 }}
                                        {{ $product->orders_count > 1 ? 'Sales' : 'Sale' }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="alert alert-danger text-center">{{ translate('No Items Found') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!--End Top Products-->
    </div>
@endsection

@section('custom_scripts')
    <!-- ======= BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <script src="{{ asset('/public/web-assets/backend/plugins/apex/apexcharts.min.js') }}"></script>
    <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <script>
        (function($) {
            "use strict";
            let chart_data_type = "monthly";
            let categories = [];
            //change chart data type
            $(".chart-switcher").on('click', function(e) {
                e.preventDefault();
                $('.chart-switcher').removeClass('active');
                $(this).addClass('active');
                chart_data_type = $(this).data('type');
                getChartData();
            });
            //Change business stat
            $("#business_insight_change").on('change', function(e) {
                let item = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: {
                        item: item
                    },
                    url: '{{ route('plugin.multivendor.seller.business.stats') }}',
                    success: function(response) {
                        if (response.success) {
                            $(".total_earning").html(response.data.total_earning);
                            $(".total_products").html(response.data.total_products);
                            $(".total_orders").html(response.data.total_orders);
                            $(".total_sales").html(response.data.total_sales);

                            $(".pending_orders").html(response.data.pending_orders);
                            $(".approved").html(response.data.approved);
                            $(".ready_to_ship").html(response.data.ready_to_ship);
                            $(".shipped-order").html(response.data.shipped);
                            $(".delivered-order").html(response.data.delivered);
                            $(".cancelled-order").html(response.data.cancelled);
                            $(".total_refunds").html(response.data.total_refunds);
                            $(".return_processing").html(response.data.return_processing);
                        }
                    }
                });
            });
            //Get data from api
            function getChartData() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: {
                        type: chart_data_type
                    },
                    url: '{{ route('plugin.multivendor.seller.reports.sales.chart') }}',
                    success: function(data) {
                        if (data.success) {
                            categories = data.times;
                            sales_chart.updateSeries([{
                                name: 'Sales',
                                data: data.sales
                            }])

                            sales_chart.updateOptions({
                                xaxis: {
                                    categories: data.times
                                }
                            })
                        }
                    }
                });
            }
            //chart options
            var sales_chart_options = {
                series: [],
                chart: {
                    height: 500,
                    type: 'bar',
                    toolbar: {
                        show: true,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    dashArray: 3
                },
                colors: ['#FFBA5A', '#8381FD'],
                grid: {
                    borderColor: '#f5f5f5',
                },
                markers: {
                    size: 7,
                    colors: ["#67CF94"],
                    hover: {
                        size: 8,
                    }
                },
                xaxis: {
                    categories: [],
                },
                yaxis: {
                    tickAmount: 4,
                },
                responsive: [{
                    breakpoint: 576,
                    options: {
                        markers: {
                            size: 5,
                            colors: ["#67CF94"],
                            hover: {
                                size: 5,
                            }
                        },
                    }
                }],
            };
            //Render chart
            var sales_chart = new ApexCharts(document.querySelector(
                "#apex_sales_report_chart"), sales_chart_options);
            sales_chart.render();

            $(document).ready(function() {
                getChartData();
            });
        })(jQuery);
    </script>
@endsection
