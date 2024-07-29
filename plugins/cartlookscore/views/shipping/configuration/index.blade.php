@php
    use Plugin\CartLooksCore\Repositories\SettingsRepository;
@endphp
@extends('core::base.layouts.master')
@section('title')
    {{ translate('Shipping & Delivery') }}
@endsection
@section('custom_css')
    <style>
        .shipping-profile-info {
            margin-right: 100px;
        }

        .shipping-profile {
            border: 1px solid #dee2e6;
        }

        .new-shipping-area {
            border: 1px dashed;
        }

        @media(max-width:575px) {
            .shipping-profile .info {
                flex-direction: column;
            }

            .shipping-profile-info {
                margin-right: 0px;
                margin-bottom: 20px;
            }

            .profile-zone,
            .border-left2 {
                padding: 0 !important;

                border-left-color: transparent !important;
            }
        }
    </style>
@endsection
@section('main_content')
    <div class="align-items-center border-bottom2 d-flex flex-wrap gap-10 justify-content-between mb-4 pb-3">
        <h4><i class="icofont-vehicle-delivery-van"></i> {{ translate('Shipping & Delivery') }}</h4>
    </div>
    <!--Shipping Options-->
    <div class="row">
        <div class="col-lg-6 col-12" id="ShippingOptions">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4>{{ translate('Shipping Options') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('plugin.cartlookscore.shipping.option.update') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="custom-radio mr-3">
                                    <input type="radio" id="flatRate" name="shipping_option"
                                        value="{{ config('cartlookscore.shipping_cost_options.flat_rate') }}"
                                        @checked(SettingsRepository::getEcommerceSetting('shipping_option') == null ||
                                                SettingsRepository::getEcommerceSetting('shipping_option') ==
                                                    config('cartlookscore.shipping_cost_options.flat_rate'))>
                                    <label for="flatRate"></label>
                                </div>
                                <label for="flatRate">Flat Rate Shipping Cost</label>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="custom-radio mr-3">
                                    <input type="radio" id="productWise" name="shipping_option"
                                        value="{{ config('cartlookscore.shipping_cost_options.product_wise_rate') }}"
                                        @checked(SettingsRepository::getEcommerceSetting('shipping_option') ==
                                                config('cartlookscore.shipping_cost_options.product_wise_rate'))>
                                    <label for="productWise"></label>
                                </div>
                                <label for="productWise">Product Wise Shipping Cost</label>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="custom-radio mr-3">
                                    <input type="radio" id="profileBased" name="shipping_option"
                                        value="{{ config('cartlookscore.shipping_cost_options.profile_wise_rate') }}"
                                        @checked(SettingsRepository::getEcommerceSetting('shipping_option') ==
                                                config('cartlookscore.shipping_cost_options.profile_wise_rate'))>
                                    <label for="profileBased"></label>
                                </div>
                                <label for="profileBased">Based on Shipping Profiles</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12" id="ConfigurationNote">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4>{{ translate('Note') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="note-container">
                        <div class="border-bottom pb-2">
                            <div class="content">
                                <div class="pr-0 pr-sm-4 fz-14">
                                    <strong>Flat Rate Shipping Cost Calculation: </strong>How many products a customer
                                    purchase,
                                    doesn't
                                    matter. Shipping cost is fixed.
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom pb-2 mt-2">
                            <div class="content">
                                <div class="pr-0 pr-sm-4 fz-14">
                                    <strong>Product Wise Shipping Cost Calculation: </strong>Shipping cost is calculate by
                                    addition of each product shipping cost.
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 pb-2">
                            <div class="content">
                                <div class="pr-0 pr-sm-4 fz-14">
                                    <strong>Profile Wise Shipping Cost Calculation: </strong>Shipping cost is calculate by
                                    selection of each product shipping profile.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Shipping Options-->
    <!--Flat Rate Shipping Options-->
    <div
        class="row {{ SettingsRepository::getEcommerceSetting('shipping_option') == null ||
        SettingsRepository::getEcommerceSetting('shipping_option') == config('cartlookscore.shipping_cost_options.flat_rate')
            ? ''
            : 'd-none' }}">
        <div class="col-lg-6 col-12">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4>{{ translate('Flat Rate Shipping Cost') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('plugin.cartlookscore.shipping.flat.rate.update') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <input type="number" name="flat_rate_shipping_cost" class="theme-input-style"
                                value="{{ SettingsRepository::getEcommerceSetting('flat_rate_shipping_cost') }}"
                                placeholder="{{ translate('Enter Shipping Cost') }}" required>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12" id="ConfigurationNote">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2 py-3">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4>{{ translate('Note') }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="note-container">
                        <div class="border-bottom pb-2">
                            <div class="content">
                                <div class="pr-0 pr-sm-4 fz-14">
                                    Flat rate shipping cost is applicable if Flat Rate Shipping Cost is enabled.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Flat Rate Shipping Options-->
    <!--Profile Based Shipping Options-->
    <div
        class="row {{ SettingsRepository::getEcommerceSetting('shipping_option') != null &&
        SettingsRepository::getEcommerceSetting('shipping_option') ==
            config('cartlookscore.shipping_cost_options.profile_wise_rate')
            ? ''
            : 'd-none' }}">
        <!--Shipping Profiles-->
        <div class="col-12">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>{{ translate('Shipping Profiles') }}</h4>
                        <div class="d-flex align-items-center gap-15">
                            <a href="{{ route('plugin.cartlookscore.shipping.profile.form') }}"
                                class="btn long">{{ translate('Create new profile') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($shipping_profiles))
                        <!--Profile List-->
                        @foreach ($shipping_profiles as $profile)
                            <div class="d-flex justify-content-between p-3 rounded shipping-profile mb-20">
                                <div class="info d-flex">
                                    <div class="shipping-profile-info">
                                        <div class="profile-name">
                                            <h4>{{ $profile->name }}</h4>
                                        </div>
                                        <div class="profile-product-info">
                                            <p class="black font-14 font-weight-lighter">{{ count($profile->products) }}
                                                Product</p>
                                            <a href="#" class="btn-danger btn-sm delete-profile"
                                                data-profile="{{ $profile->id }}">{{ translate('Delete Profile') }}</a>
                                        </div>
                                    </div>
                                    <div class="border-left2 pl-3 profile-zone">
                                        @if (count($profile->zones) > 0)
                                            <div class="zone-info">
                                                <h5>{{ translate('Shipping Zone') }}</h5>
                                                @foreach ($profile->zones as $zone)
                                                    <p class="black font-14 font-weight-lighter m-0"><i
                                                            class="icofont-location-pin"></i>
                                                        {{ $zone->name }}</p>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="black">
                                                {{ translate('No shipping rates available for products in this profile') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="action-area">
                                    <a href="{{ route('plugin.cartlookscore.shipping.profile.manage', $profile->id) }}"
                                        class="btn long">{{ translate('Manage') }}</a>

                                </div>
                            </div>
                        @endforeach
                        <!--End Profile List-->
                    @else
                        <p class="alert alert-danger text-center">{{ translate('No Profile Created yet') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <!--End Shipping Profiles-->
        <!--Shipping Processing Time-->
        <div class="col-12" id="ShippingTimes">
            <div class="card mb-30">
                <div class="card-header bg-white border-bottom2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>{{ translate('Shipping Time') }}</h4>
                        <div class="d-flex align-items-center gap-15">
                            <a href="#" class="btn long mr-2" data-toggle="modal"
                                data-target="#new-shipping-time-modal">{{ translate('Create new Time') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="dh-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Min Shipping Time') }}</th>
                                    <th>{{ translate('Max Shipping Time') }}</th>
                                    <th class="text-right">{{ translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($shippingTimes) > 0)
                                    @foreach ($shippingTimes as $key => $time)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $time->min_value }} {{ $time->min_unit }}</td>
                                            <td>{{ $time->max_value }} {{ $time->max_unit }}</td>
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
                                                        <a href="#" data-item="{{ $time->id }}"
                                                            class="delete-shipping-time">{{ translate('Delete') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">
                                            <p class="alert alert-danger text-center">{{ translate('Nothing found') }}</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--End Shipping Processing Time-->
    </div>
    <!--End Profile Based Shipping Options-->
    <!--New Shipping time Modal-->
    <div id="new-shipping-time-modal" class="new-shipping-time-modal modal fade show" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6 bold">{{ translate('Add New Shipping Time') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new-shipping-time-form">
                        @csrf
                        <div class="form-row mb-20">
                            <div class="form-group col-sm-12">
                                <div>
                                    <label class="font-14 bold black">{{ translate('Minimum Shipping Time') }} </label>
                                </div>
                                <div class="input-group addon">
                                    <input type="text" name="minimmum_shipping_time" value="" placeholder="0"
                                        class="form-control style--two">
                                    <div class="input-group-append">
                                        <select class="form-control" name="minimmum_shipping_time_unit">
                                            <option value="Days">{{ translate('Days') }}</option>
                                            <option value="Hours">{{ translate('Hours') }}</option>
                                            <option value="Minutes">{{ translate('Minutes') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div>
                                    <label class="font-14 bold black">{{ translate('Maximum Shipping Time') }} </label>
                                </div>
                                <div class="input-group addon">
                                    <input type="text" name="maximum_shipping_time" value="" placeholder="0"
                                        class="form-control style--two">
                                    <div class="input-group-append">
                                        <select class="form-control" name="maximum_shipping_time_unit">
                                            <option value="Days">{{ translate('Days') }}</option>
                                            <option value="Hours">{{ translate('Hours') }}</option>
                                            <option value="Minutes">{{ translate('Minutes') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 text-right">
                                <button type="submit"
                                    class="btn long store-shiping-time-btn">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End New Shipping time Modal-->
    <!--Delete Shipping Profile Modal-->
    <div id="delete-profile-modal" class="delete-profile-modal modal fade show" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                    <form method="POST" action="{{ route('plugin.cartlookscore.shipping.profile.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-profile-id" name="id">
                        <button type="button" class="btn long btn-danger mt-2"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Shipping Profile Modal-->
    <!--Delete Shipping Time Modal-->
    <div id="delete-shipping-time-modal" class="delete-shipping-time-modal modal fade show" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to delete this') }}?</p>
                    <form method="POST" action="{{ route('plugin.cartlookscore.shipping.time.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-time-id" name="id">
                        <button type="button" class="btn long btn-danger mt-2"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Shipping Time Modal-->
@endsection
@section('custom_scripts')
    <script>
        (function($) {
            "use strict";
            /**
             * Store new shipping time
             * 
             **/
            $('.store-shiping-time-btn').on('click', function(e) {
                e.preventDefault();
                $(document).find(".invalid-input").remove();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: $('#new-shipping-time-form').serialize(),
                    url: '{{ route('plugin.cartlookscore.shipping.time.store') }}',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        $.each(response.responseJSON.errors, function(field_name, error) {
                            $(document).find('[name=' + field_name + ']').next(
                                '.input-group-append').after(
                                '<div class="invalid-input">' + error + '</div>')
                        })
                    }
                });
            })
            /**
             *Delete shipping profile
             *  
             **/
            $('.delete-profile').on('click', function(e) {
                e.preventDefault();
                let $this = $(this);
                let id = $this.data('profile');
                $('#delete-profile-id').val(id);
                $('.delete-profile-modal').modal('show');
            })
            /** 
             * Delete shipping time
             *  
             **/
            $('.delete-shipping-time').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('item');
                $("#delete-time-id").val(id);
                $("#delete-shipping-time-modal").modal('show');
            });
        })(jQuery);
    </script>
@endsection
