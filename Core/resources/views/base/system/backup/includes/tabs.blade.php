<ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs(['core.backup.files.list']) ? 'active' : '' }}"
            href="{{ route('core.backup.files.list') }}">{{ translate('Files Backup') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs(['core.backup.database.list']) ? 'active' : '' }}"
            href="{{ route('core.backup.database.list') }}">{{ translate('Database Backup') }}</a>
    </li>
</ul>
