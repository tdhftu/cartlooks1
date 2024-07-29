@if (auth()->user()->can('Manage Seller Products'))
    <li class="{{ Request::routeIs(['plugin.multivendor.admin.seller.products.list']) ? 'active ' : '' }}">
        <a
            href="{{ route('plugin.multivendor.admin.seller.products.list') }}">{{ translate('Seller Products') }}</a><span
            class="badge badge-danger ml-2">{{ translate('Addon') }}</span>
    </li>
@endif
