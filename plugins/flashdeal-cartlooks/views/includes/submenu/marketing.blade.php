@php
    $isactivateFlashdeal = isActivePlugin('flashdeal-cartlooks');
@endphp
@if ($isactivateFlashdeal)
    @if (auth()->user()->can('Manage Flash Deals'))
        <li class="{{ Request::routeIs(['plugin.flashdeal.list']) ? 'active ' : '' }}">
            <a href="{{ route('plugin.flashdeal.list') }}">{{ translate('Flash Deals') }}<span
                    class="badge badge-danger ml-2">{{ translate('Addon') }}</span></a>
        </li>
    @endif
@endif
