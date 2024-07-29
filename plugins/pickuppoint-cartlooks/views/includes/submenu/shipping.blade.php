@if (isActivePlugin('pickuppoint-cartlooks'))
    <li
        class="{{ Request::routeIs(['plugin.pickuppoint.edit.pickup.point', 'plugin.pickuppoint.pickup.points']) ? 'active ' : '' }}">
        <a href="{{ route('plugin.pickuppoint.pickup.points') }}">{{ translate('Pickup Points') }}<span
                class="badge badge-danger ml-2">{{ translate('Addon') }}</span></a>
    </li>
@endif
