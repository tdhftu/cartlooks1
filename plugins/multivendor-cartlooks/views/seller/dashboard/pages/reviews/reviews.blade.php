@extends('plugin/multivendor-cartlooks::seller.dashboard.layouts.seller_master')
@section('title')
    {{ translate('Reviews') }}
@endsection
@section('custom_css')
    <link href="{{ asset('/public/web-assets/backend/css/ratings.css') }}" rel="stylesheet" />
@endsection
@section('seller_main_content')
    @if (auth()->user()->shop->status == config('settings.general_status.active'))
        <div class="row">
            <div class="col-12">
                <div class="card mb-30">
                    <div class="card-body border-bottom2 mb-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="font-20">{{ translate('Product Reviews') }}</h4>
                        </div>
                    </div>
                    <div class="px-2 filter-area d-flex align-items-center mb-10">
                        <form method="get" action="{{ route('plugin.multivendor.seller.dashboard.reviews.list') }}">
                            <select class="theme-input-style mb-2" name="per_page">
                                <option value="">{{ translate('Per page') }}</option>
                                <option value="20" @selected(request()->has('per_page') && request()->get('per_page') == '20')>20</option>
                                <option value="50" @selected(request()->has('per_page') && request()->get('per_page') == '50')>50</option>
                                <option value="all" @selected(request()->has('per_page') && request()->get('per_page') == 'all')>All</option>
                            </select>
                            <select class="theme-input-style mb-2" name="status">
                                <option value="">{{ translate('Visibility') }}</option>
                                <option value="{{ config('settings.general_status.active') }}" @selected(request()->has('status') && request()->get('status') == config('settings.general_status.active'))>
                                    {{ translate('Visible') }}</option>
                                <option value="{{ config('settings.general_status.in_active') }}"
                                    @selected(request()->has('status') && request()->get('status') == config('settings.general_status.in_active'))>
                                    {{ translate('Hide') }}</option>
                            </select>
                            <select class="theme-input-style mb-2" name="rating">
                                <option value="">{{ translate('Filter by rating') }}</option>
                                <option value="5" @selected(request()->has('rating') && request()->get('rating') == '5')>5</option>
                                <option value="4" @selected(request()->has('rating') && request()->get('rating') == '4')>4</option>
                                <option value="3" @selected(request()->has('rating') && request()->get('rating') == '3')>3</option>
                                <option value="2" @selected(request()->has('rating') && request()->get('rating') == '2')>2</option>
                                <option value="1" @selected(request()->has('rating') && request()->get('rating') == '1')>1</option>
                            </select>

                            <input type="text" name="search" class="theme-input-style mb-2"
                                value="{{ request()->has('search') ? request()->get('search') : '' }}"
                                placeholder="Enter order code, product name , customer name">
                            <button type="submit" class="btn long">{{ translate('Filter') }}</button>
                        </form>

                        <a class="btn long btn-danger"
                            href="{{ route('plugin.multivendor.seller.dashboard.reviews.list') }}">{{ translate('Clear Filter') }}</a>

                    </div>
                    <div class="table-responsive">
                        <table id="reviewTable" class="hoverable text-nowrap border-top2">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>{{ translate('Product') }}</th>
                                    <th>{{ translate('Customer') }}</th>
                                    <th>{{ translate('Order') }}</th>
                                    <th>{{ translate('Rating') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th>{{ translate('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($reviews->count() > 0)
                                    @foreach ($reviews as $key => $review)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                <a href="{{ route('plugin.multivendor.seller.dashboard.products.edit', ['id' => $review->product_id, 'lang' => getDefaultLang()]) }}"
                                                    target="_blank">
                                                    {{ $review->product_name }}
                                                </a>

                                            </td>
                                            <td>
                                                {{ $review->customer_name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('plugin.multivendor.seller.dashboard.order.details', ['id' => $review->order_id]) }}"
                                                    target="_blank">
                                                    {{ $review->order_code }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="product-rating-wrapper">
                                                    <i data-star="{{ $review->rating }}"
                                                        title="{{ $review->rating }}"></i><span>{{ $review->rating }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($review->status == config('settings.general_status.active'))
                                                    <p class="badge badge-success">{{ translate('Visible') }}</p>
                                                @else
                                                    <p class="badge badge-danger">{{ translate('Hidden') }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown-button">
                                                    <a href="#" class="d-flex align-items-center justify-content-end"
                                                        data-toggle="dropdown">
                                                        <div class="menu-icon mr-0">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="review-details"
                                                            data-review="{{ $review->id }}">
                                                            {{ translate('Details') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">
                                            <p class="alert alert-danger text-center">{{ translate('Nothing found') }}
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pgination px-3">
                            {!! $reviews->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5-custom') !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--Details Modal-->
        <div id="details-modal" class="details-modal modal fade show" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title h6 font-weight-bold">{{ translate('Review Details') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="detail-content"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--Details Modal-->
    @else
        <p class="alert alert-info">Your Shop is Inactive. Please contact with Administration </p>
    @endif
@endsection
@section('custom_scripts')
    <script>
        (function($) {
            "use strict";
            /**
             * Get review details
             **/
            $('.review-details').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('review');
                $.post('{{ route('plugin.cartlookscore.product.reviews.details') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function(data) {
                    $('.detail-content').html(data);
                    $('#details-modal').modal('show');
                })
            });
        })(jQuery);
    </script>
@endsection
