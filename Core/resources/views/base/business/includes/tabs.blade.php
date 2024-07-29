<div class="nav flex-column border-right2 py-3" aria-orientation="vertical">
    @if (auth()->user()->can('Manage General Settings'))
        <a class="nav-link {{ Request::routeIs(['core.general.settings']) ? 'active ' : '' }}"
            href="{{ route('core.general.settings') }}">
            <i class="icofont-ui-settings" title="{{ translate('General') }}"></i>
            <span>{{ translate('General') }}</span>
        </a>
    @endif
    @if (auth()->user()->can('Manage Email Settings'))
        <a class="nav-link {{ Request::routeIs(['core.email.smtp.configuration']) ? 'active ' : '' }}"
            href="{{ route('core.email.smtp.configuration') }}">
            <i class="icofont-email" title="{{ translate('Email settings') }}"></i>
            <span>{{ translate('Email settings') }}</span>
        </a>
    @endif

    @if (auth()->user()->can('Manage Email Templates'))
        <a class="nav-link {{ Request::routeIs(['core.email.templates']) ? 'active ' : '' }}"
            href="{{ route('core.email.templates') }}">
            <i class="icofont-ui-email" title="{{ translate('Email Templates') }}"></i>
            <span>{{ translate('Email Templates') }}</span>
        </a>
    @endif

    @if (auth()->user()->can('Manage Media Settings'))
        <a class="nav-link {{ Request::routeIs(['core.media.settings']) ? 'active ' : '' }}"
            href="{{ route('core.media.settings') }}">
            <i class="icofont-multimedia" title="{{ translate('Media settings') }}"></i>
            <span>{{ translate('Media settings') }}</span>
        </a>
    @endif

    @if (auth()->user()->can('Manage Seo Settings'))
        <a class="nav-link {{ Request::routeIs(['core.seo.settings']) ? 'active ' : '' }}"
            href="{{ route('core.seo.settings') }}">
            <i class="icofont-page" title="{{ translate('SEO settings') }}"></i>
            <span>{{ translate('SEO settings') }}</span>
        </a>
    @endif
</div>
