<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
    role="navigation" data-menu="menu-wrapper">

    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

            {{-- الرئيسية --}}
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="la la-home"></i>
                    <span>الرئيسية</span>
                </a>
            </li>


            @can('التحكم بالاعدادات الاساسية للنظام')
                <li class="nav-item {{ request()->routeIs('setting') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('setting') }}">
                        <i class="la la-cog"></i>
                        <span>الإعدادات</span>
                    </a>
                </li>
            @endcan
            {{-- إدارة المستخدمين والصلاحيات --}}
            @can('ادارة المستخدمين')
                <li
                    class="dropdown nav-item
    {{ request()->routeIs('dashboard.users.*') ||
    request()->routeIs('dashboard.roles.*') ||
    request()->routeIs('dashboard.permissions.*')
        ? 'active'
        : '' }}">

                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">
                        <i class="la la-users-cog"></i>
                        <span>إدارة المستخدمين</span>
                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard.users.index') }}">
                                <i class="la la-users"></i>
                                المستخدمين
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard.roles.index') }}">
                                <i class="la la-user-shield"></i>
                                الأدوار
                            </a>
                        </li>

                        <!-- <li>
                            <a class="dropdown-item" href="{{ route('dashboard.permissions.index') }}">
                                <i class="la la-key"></i>
                                الصلاحيات
                            </a>
                        </li> -->

                    </ul>
                </li>
            @endcan



            {{-- إعدادات الصفحة الرئيسية --}}
            @can('التحكم باعدادات الصفحة الرئيسية')
                <li
                    class="dropdown nav-item
    {{ request()->routeIs('home-hero.*') ||
    request()->routeIs('home-stats.*') ||
    request()->routeIs('home-services.*') ||
    request()->routeIs('sectors.*')
        ? 'active'
        : '' }}">

                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">
                        <i class="la la-layer-group"></i>
                        <span>إعدادات الصفحة الرئيسية</span>
                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="{{ route('home-hero.edit') }}">
                                <i class="la la-image"></i>
                                هيرو الصفحة الرئيسية
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('home-stats.edit') }}">
                                <i class="la la-chart-bar"></i>
                                الاستراتيجيات
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('home-services.index') }}">
                                <i class="la la-cubes"></i>
                                الخدمات
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('sectors.index') }}">
                                <i class="la la-th-large"></i>
                                القطاعات
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route(name: 'dashboard.news.index') }}">
                                <i class="la la-newspaper"></i>
                                الاخبار
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard.home-sections.index') }}">
                                <i class="la la-edit"></i>
                                إعدادات الصفحة الرئيسية
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('ادارة الصفحات')
                <li class="nav-item {{ request()->routeIs('dashboard.pages.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.pages.index') }}">
                        <i class="la la-file-alt"></i>
                        <span>إدارة الصفحات</span>
                    </a>
                </li>
            @endcan

            @can('ادارة الوظائف')
                <li
                    class="dropdown nav-item
            {{ request()->routeIs('dashboard.jobs.*') || request()->routeIs('dashboard.job-groups.*') ? 'active' : '' }}">

                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">
                        <i class="la la-briefcase"></i>
                        <span>إدارة الوظائف</span>
                    </a>

                    <ul class="dropdown-menu">

                        {{-- تصنيفات الوظائف --}}
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('dashboard.job-groups.*') ? 'active' : '' }}"
                                href="{{ route('dashboard.job-groups.index') }}">
                                <i class="la la-folder"></i>
                                تصنيفات الوظائف
                            </a>
                        </li>

                        {{-- جميع الوظائف --}}
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('dashboard.jobs.index') ? 'active' : '' }}"
                                href="{{ route('dashboard.jobs.index') }}">
                                <i class="la la-list"></i>
                                جميع الوظائف
                            </a>
                        </li>



                        {{-- إضافة وظيفة --}}
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('dashboard.jobs.create') ? 'active' : '' }}"
                                href="{{ route('dashboard.jobs.create') }}">
                                <i class="la la-plus-circle"></i>
                                إضافة وظيفة
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan


            @can('ادراة طلبات التواصل')
                <li class="nav-item {{ request()->routeIs('dashboard.contacts.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.contacts.index') }}">
                        <i class="la la-phone"></i>
                        <span> طلبات التواصل</span>
                    </a>
                </li>
            @endcan

            <li class="nav-item {{ request()->routeIs('dashboard.media*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.media.index') }}">
                    <i class="las la-photo-video"></i>
                    <span>الوسائط </span>
                </a>
            </li>


        </ul>
    </div>
</div>
