<nav class="sidebar" data-trigger="scrollbar">
    <!--Search Options-->
    <div class="sidebar-search-bar m-2">
        <div class="input-group addon ov-hidden">
            <input type="text" class="search-input theme-input-style search-in-sidebar text-white"
                placeholder="{{ translate('Search in Menu') }}">
        </div>
    </div>
    <!--End search options-->
    <!-- Sidebar Header -->
    <div class="sidebar-header d-none d-lg-block pt-0">
        <!-- Sidebar Toggle Pin Button -->
        <div class="sidebar-toogle-pin">
            <i class="icofont-tack-pin"></i>
        </div>
        <!-- End Sidebar Toggle Pin Button -->
    </div>
    <!-- End Sidebar Header -->
    <!-- Sidebar Body -->
    <div class="sidebar-body main-side-bar">
        <!-- Nav -->
        <ul class="nav" id="main-nav">
            @if (auth()->user()->can('Manage Dashboard'))
                <li class="{{ Request::routeIs('admin.dashboard') ? 'active ' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icofont-dashboard"></i>
                        <span class="link-title">{{ translate('Dashboard') }}</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->can('Manage Media'))
                <!--Media Module-->
                <li class="{{ Request::routeIs(['core.media.page']) ? 'active ' : '' }}">
                    <a href="{{ route('core.media.page') }}">
                        <i class="icofont-multimedia"></i>
                        <span class="link-title">{{ translate('Media') }}</span>
                    </a>

                </li>
                <!--End Media module-->
            @endif
            <!-- Blog & Page-->
            <!--Blog Module-->
            @canany(['Show Blog', 'Create Blog', 'Manage Category', 'Manage Tag', 'Manage Comment'])
                <li
                    class="{{ Request::routeIs(['core.blog.category', 'core.add.blog.category', 'core.edit.blog.category', 'core.blog', 'core.add.blog', 'core.edit.blog', 'core.tag', 'core.edit.tag', 'core.add.tag', 'core.blog.comment', 'core.blog.comment.edit', 'core.blog.comment.setting']) ? 'active sub-menu-opened' : '' }}">
                    <a href="#">
                        <i class="icofont-blogger"></i>
                        <span class="link-title">{{ translate('Blog') }}</span>
                    </a>
                    <ul class="nav sub-menu">
                        @can('Create Blog')
                            <li class="{{ Request::routeIs('core.add.blog') ? 'active ' : '' }}">
                                <a href="{{ route('core.add.blog') }}">{{ translate('Write New Blog') }}</a>
                            </li>
                        @endcan
                        @can('Show Blog')
                            <li class="{{ Request::routeIs(['core.blog', 'core.edit.blog']) ? 'active ' : '' }}">
                                <a href="{{ route('core.blog') }}">{{ translate('All Blogs') }}</a>
                            </li>
                        @endcan
                        @can('Manage Category')
                            <li
                                class="{{ Request::routeIs(['core.blog.category', 'core.add.blog.category', 'core.edit.blog.category']) ? 'active ' : '' }}">
                                <a href="{{ route('core.blog.category') }}">{{ translate('Categories') }}</a>
                            </li>
                        @endcan
                        @can('Manage Tag')
                            <li class="{{ Request::routeIs(['core.tag', 'core.add.tag', 'core.edit.tag']) ? 'active ' : '' }}">
                                <a href="{{ route('core.tag') }}">{{ translate('Tags') }}</a>
                            </li>
                        @endcan
                        @can('Manage Comment')
                            <li
                                class="{{ Request::routeIs(['core.blog.comment', 'core.blog.comment.edit']) ? 'active ' : '' }}">
                                <a href="{{ route('core.blog.comment') }}">{{ translate('Comments') }}</a>
                            </li>
                        @endcan
                        @can('Manage Blog Settings')
                            <li class="{{ Request::routeIs(['core.blog.comment.setting']) ? 'active sub-menu-opened' : '' }}">
                                <a href="#">
                                    <span class="link-title">{{ translate('Settings') }}</span>
                                </a>
                                <ul class="nav sub-menu">
                                    <li class="{{ Request::routeIs(['core.blog.comment.setting']) ? 'active' : '' }}">
                                        <a
                                            href="{{ route('core.blog.comment.setting') }}">{{ translate('Comment Settings') }}</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!--End Blog module-->

            <!--Page Module-->
            @canany(['Show Page', 'Create Page'])
                <li
                    class="{{ Request::routeIs(['core.page', 'core.page.add', 'core.page.edit']) ? 'active sub-menu-opened' : '' }}">
                    <a href="#">
                        <i class="icofont-page"></i>
                        <span class="link-title">{{ translate('Pages') }}</span>
                    </a>
                    <ul class="nav sub-menu">
                        @can('Show Page')
                            <li class="{{ Request::routeIs(['core.page', 'core.page.edit']) ? 'active ' : '' }}">
                                <a href="{{ route('core.page') }}">{{ translate('All Pages') }}</a>
                            </li>
                        @endcan
                        @can('Create Page')
                            <li class="{{ Request::routeIs('core.page.add') ? 'active ' : '' }}">
                                <a href="{{ route('core.page.add') }}">{{ translate('Add New Page') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!--End Blog module-->
            <!-- Blog & Page -->

            <!--Plugin nabvar options-->
            @foreach (pluginNavbar() as $item)
                @includeIf($item)
            @endforeach
            <!--End Plugin nabvar options-->

            <!--Appearances Modules-->
            @if (auth()->user()->can('Manage Themes') ||
                    auth()->user()->can('Manage Menus'))
                <li
                    class="{{ Request::routeIs(['core.themes.index', 'core.manage.menus']) ? 'active sub-menu-opened' : '' }}">
                    <a href="#">
                        <i class="icofont-brand-designfloat"></i>
                        <span class="link-title">{{ translate('Appearances') }}</span>
                    </a>
                    <ul class="nav sub-menu">
                        @if (auth()->user()->can('Manage Themes'))
                            <li class="{{ Request::routeIs(['core.themes.index']) ? 'active ' : '' }}">
                                <a href="{{ route('core.themes.index') }}">{{ translate('Themes') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Manage Menus'))
                            <li class="{{ Request::routeIs(['core.manage.menus']) ? 'active ' : '' }}">
                                <a href="{{ route('core.manage.menus') }}">{{ translate('Menus') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <!--End Appearances Modules-->

            <!--Theme otions-->
            @includeIf(getActiveThemeOptions())
            <!--End Theme options-->

            @if (auth()->user()->can('Manage Plugins'))
                <!--Plugins Module-->
                <li class="{{ Request::routeIs(['core.plugins.index', 'core.plugins.create']) ? 'active' : '' }}">
                    <a href="{{ route('core.plugins.index') }}">
                        <i class="icofont-addons"></i>
                        <span class="link-title">{{ translate('Plugins') }}</span>
                    </a>
                </li>
                <!--End Plugins module-->
            @endif

            <!--Users Module-->
            @if (auth()->user()->can('Show User') ||
                    auth()->user()->can('Show Role') ||
                    auth()->user()->can('Show Permission'))
                <li
                    class="{{ Request::routeIs(['core.roles', 'core.permissions', 'core.users', 'core.add.user', 'core.edit.user']) ? 'active sub-menu-opened' : '' }}">
                    <a href="#">
                        <i class="icofont-users-social"></i>
                        <span class="link-title">{{ translate('Users') }}</span>
                    </a>
                    <ul class="nav sub-menu">
                        @if (auth()->user()->can('Show User'))
                            <li
                                class="{{ Request::routeIs(['core.users', 'core.add.user', 'core.edit.user']) ? 'active ' : '' }}">
                                <a href="{{ route('core.users') }}">{{ translate('Users') }}</a>
                            </li>
                        @endif

                        @if (auth()->user()->can('Show Role'))
                            <li class="{{ Request::routeIs(['core.roles']) ? 'active ' : '' }}"><a
                                    href="{{ route('core.roles') }}">{{ translate('Roles') }}</a></li>
                        @endif

                        @if (auth()->user()->can('Show Permission'))
                            <li class="{{ Request::routeIs(['core.permissions']) ? 'active ' : '' }}">
                                <a href="{{ route('core.permissions') }}">{{ translate('Permissions') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <!--End users-->
            <!--Business Settings Modules-->
            @if (auth()->user()->can('Manage General Settings') ||
                    auth()->user()->can('Manage Email Settings') ||
                    auth()->user()->can('Manage Email Templates') ||
                    auth()->user()->can('Manage Media Settings') ||
                    auth()->user()->can('Manage Seo Settings'))
                <li
                    class="{{ Request::routeIs(['core.seo.settings', 'core.email.smtp.configuration', 'core.media.settings', 'core.email.templates', 'core.media.settings', 'core.general.settings']) ? 'active' : '' }}">
                    <a href="{{ route('core.general.settings') }}">
                        <i class="icofont-settings-alt"></i>
                        <span class="link-title">{{ translate('Business Settings') }}</span>
                    </a>
                </li>
            @endif
            <!--End Business Settings Modules-->

            <!--System Module--->
            <li
                class="{{ Request::routeIs(['core.language.frontend.translations', 'core.language.edit', 'core.language.key.values', 'core.languages', 'core.language.new', 'core.system.update.page', 'core.backup.files.list', 'core.backup.database.list']) ? 'active sub-menu-opened' : '' }}">
                <a href="#">
                    <i class="icofont-wrench"></i>
                    <span class="link-title">{{ translate('System') }}</span>
                </a>
                <ul class="nav sub-menu">
                    @if (auth()->user()->can('Manage Update'))
                        <li class="{{ Request::routeIs(['core.system.update.page']) ? 'active ' : '' }}">
                            <a href="{{ route('core.system.update.page') }}">{{ translate('Update') }}</a>
                        </li>
                    @endif
                    @if (auth()->user()->can('Manage Backups'))
                        <li
                            class="{{ Request::routeIs(['core.backup.files.list', 'core.backup.database.list']) ? 'active ' : '' }}">
                            <a href="{{ route('core.backup.files.list') }}">{{ translate('Backups') }}</a>
                        </li>
                    @endif
                    @if (auth()->user()->can('Manage Language'))
                        <li class="{{ Request::routeIs(['core.languages']) ? 'active ' : '' }}">
                            <a href="{{ route('core.languages') }}">{{ translate('Languages') }}</a>
                        </li>
                    @endif
                </ul>
            </li>
            <!--End system Module-->

            <!--Activity Logs Module-->
            @if (auth()->user()->can('Manage Login activity'))
                <li
                    class="{{ Request::routeIs(['core.activity.logs', 'core.get.login.activity']) ? 'active sub-menu-opened' : '' }}">
                    <a href="#">
                        <i class="icofont-ui-password"></i>
                        <span class="link-title">{{ translate('Activity Logs') }}</span>
                    </a>
                    <ul class="nav sub-menu">
                        <li class="{{ Request::routeIs(['core.get.login.activity']) ? 'active ' : '' }}">
                            <a href="{{ route('core.get.login.activity') }}">{{ translate('Login activity') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            <!--Activity Logs Settings Module-->
        </ul>
        <!-- End Nav -->
    </div>
    <!-- End Sidebar Body -->
    <!--Side bar search result-->
    <div class="sidebar-body search-side-bar d-none">
        <!-- Nav -->
        <ul class="nav">
            <li>Hello</li>
        </ul>
    </div>
    <!--End sidebar search result-->
</nav>
