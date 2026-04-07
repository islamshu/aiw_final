<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
    role="navigation" data-menu="menu-wrapper">

    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

            
            <li class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">
                    <i class="la la-home"></i>
                    <span>الرئيسية</span>
                </a>
            </li>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('التحكم بالاعدادات الاساسية للنظام')): ?>
                <li class="nav-item <?php echo e(request()->routeIs('setting') ? 'active' : ''); ?>">
                    <a class="nav-link" href="<?php echo e(route('setting')); ?>">
                        <i class="la la-cog"></i>
                        <span>الإعدادات</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ادارة المستخدمين')): ?>
                <li
                    class="dropdown nav-item
    <?php echo e(request()->routeIs('dashboard.users.*') ||
    request()->routeIs('dashboard.roles.*') ||
    request()->routeIs('dashboard.permissions.*')
        ? 'active'
        : ''); ?>">

                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">
                        <i class="la la-users-cog"></i>
                        <span>إدارة المستخدمين</span>
                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('dashboard.users.index')); ?>">
                                <i class="la la-users"></i>
                                المستخدمين
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('dashboard.roles.index')); ?>">
                                <i class="la la-user-shield"></i>
                                الأدوار
                            </a>
                        </li>

                        <!-- <li>
                            <a class="dropdown-item" href="<?php echo e(route('dashboard.permissions.index')); ?>">
                                <i class="la la-key"></i>
                                الصلاحيات
                            </a>
                        </li> -->

                    </ul>
                </li>
            <?php endif; ?>



            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('التحكم باعدادات الصفحة الرئيسية')): ?>
                <li
                    class="dropdown nav-item
    <?php echo e(request()->routeIs('home-hero.*') ||
    request()->routeIs('home-stats.*') ||
    request()->routeIs('home-services.*') ||
    request()->routeIs('sectors.*')
        ? 'active'
        : ''); ?>">

                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">
                        <i class="la la-layer-group"></i>
                        <span>إعدادات الصفحة الرئيسية</span>
                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('home-hero.edit')); ?>">
                                <i class="la la-image"></i>
                                هيرو الصفحة الرئيسية
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('home-stats.edit')); ?>">
                                <i class="la la-chart-bar"></i>
                                الاستراتيجيات
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('home-services.index')); ?>">
                                <i class="la la-cubes"></i>
                                الخدمات
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('sectors.index')); ?>">
                                <i class="la la-th-large"></i>
                                القطاعات
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route(name: 'dashboard.news.index')); ?>">
                                <i class="la la-newspaper"></i>
                                الاخبار
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('dashboard.home-sections.index')); ?>">
                                <i class="la la-edit"></i>
                                إعدادات الصفحة الرئيسية
                            </a>
                        </li>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ادارة الصفحات')): ?>
                <li class="nav-item <?php echo e(request()->routeIs('dashboard.pages.*') ? 'active' : ''); ?>">
                    <a class="nav-link" href="<?php echo e(route('dashboard.pages.index')); ?>">
                        <i class="la la-file-alt"></i>
                        <span>إدارة الصفحات</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ادارة الوظائف')): ?>
                <li
                    class="dropdown nav-item
            <?php echo e(request()->routeIs('dashboard.jobs.*') || request()->routeIs('dashboard.job-groups.*') ? 'active' : ''); ?>">

                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">
                        <i class="la la-briefcase"></i>
                        <span>إدارة الوظائف</span>
                    </a>

                    <ul class="dropdown-menu">

                        
                        <li>
                            <a class="dropdown-item <?php echo e(request()->routeIs('dashboard.job-groups.*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('dashboard.job-groups.index')); ?>">
                                <i class="la la-folder"></i>
                                تصنيفات الوظائف
                            </a>
                        </li>

                        
                        <li>
                            <a class="dropdown-item <?php echo e(request()->routeIs('dashboard.jobs.index') ? 'active' : ''); ?>"
                                href="<?php echo e(route('dashboard.jobs.index')); ?>">
                                <i class="la la-list"></i>
                                جميع الوظائف
                            </a>
                        </li>



                        
                        <li>
                            <a class="dropdown-item <?php echo e(request()->routeIs('dashboard.jobs.create') ? 'active' : ''); ?>"
                                href="<?php echo e(route('dashboard.jobs.create')); ?>">
                                <i class="la la-plus-circle"></i>
                                إضافة وظيفة
                            </a>
                        </li>

                    </ul>
                </li>
            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ادراة طلبات التواصل')): ?>
                <li class="nav-item <?php echo e(request()->routeIs('dashboard.contacts.*') ? 'active' : ''); ?>">
                    <a class="nav-link" href="<?php echo e(route('dashboard.contacts.index')); ?>">
                        <i class="la la-phone"></i>
                        <span> طلبات التواصل</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item <?php echo e(request()->routeIs('dashboard.media*') ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('dashboard.media.index')); ?>">
                    <i class="las la-photo-video"></i>
                    <span>الوسائط </span>
                </a>
            </li>


        </ul>
    </div>
</div>
<?php /**PATH C:\laragon\www\aiw_rtl\resources\views/dashboard/inc/aside.blade.php ENDPATH**/ ?>