@if (auth()->user()->can('Manage Seller Orders'))
    <li class="{{ Request::routeIs(['plugin.multivendor.admin.seller.order.list']) ? 'active ' : '' }}">
        <a href="{{ route('plugin.multivendor.admin.seller.order.list') }}">{{ translate('Seller Orders') }}</a><span
            class="badge badge-danger ml-2">{{ translate('Addon') }}</span>
    </li>
@endif
