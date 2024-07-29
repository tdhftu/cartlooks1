@php
    $isactivateCoupon = isActivePlugin('coupon-cartlooks');
@endphp
@if ($isactivateCoupon)
    @if (auth()->user()->can('Manage Coupons'))
        <li
            class="{{ Request::routeIs(['plugin.coupon.marketing.coupon.create.new', 'plugin.coupon.marketing.coupon.edit', 'plugin.coupon.marketing.coupon.list']) ? 'active ' : '' }}">
            <a href="{{ route('plugin.coupon.marketing.coupon.list') }}">{{ translate('Coupons') }}<span
                    class="badge badge-danger ml-2">{{ translate('Addon') }}</span></a>
        </li>
    @endif
@endif
