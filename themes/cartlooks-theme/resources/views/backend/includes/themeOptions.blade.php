<!--Theme Options Modules-->
@if (auth()->user()->can('Manage Theme settings') ||
        auth()->user()->can('Manage Widget'))
    <li
        class="{{ Request::routeIs(['theme.cartlooks-theme.widgets', 'theme.cartlooks-theme.options']) ? 'active sub-menu-opened' : '' }}">
        <a href="#">
            <i class="icofont-ui-theme"></i>
            <span class="link-title">{{ translate('Theme Options') }}</span>
        </a>
        <ul class="nav sub-menu">
            @if (auth()->user()->can('Manage Theme settings'))
                <li class="{{ Request::routeIs(['theme.cartlooks-theme.options']) ? 'active ' : '' }}">
                    <a href="{{ route('theme.cartlooks-theme.options') }}">
                        {{ translate('Theme settings') }}
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Manage Widget'))
                <!--Widget Module-->
                <li class="{{ Request::routeIs(['theme.cartlooks-theme.widgets']) ? 'active ' : '' }}">
                    <a href="{{ route('theme.cartlooks-theme.widgets') }}">
                        {{ translate('Widgets') }}
                    </a>
                </li>
                <!--End Widget Module-->
            @endif
        </ul>
    </li>
@endif
<!--End Theme Options Modules-->
