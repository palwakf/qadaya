<div class="kt-header__topbar">
    <!--begin: Notifications -->
    <!--end: Quick panel toggler --><!--begin: Language bar -->
    <!--end: Language bar --><!--begin: User Bar -->


    <!--begin: User Bar -->
    <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
            <div class="kt-header__topbar-user">
                <span class="kt-header__topbar-welcome kt-hidden-mobile">مرحباً بكـ ,</span>
                <span class="kt-header__topbar-username kt-hidden-mobile">{{ Auth::guard('admin')->user()->name }}</span>
                <img class="kt-hidden" alt="Pic" src="assets/admin/media/users/300_25.jpg" />
                @php
                    $name = mb_substr(Auth::guard('admin')->user()->name, 0, 1);
                @endphp
                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                <span class="kt-badge kt-badge--username kt-badge--unified-brand kt-badge--lg kt-badge--rounded kt-badge--bold">{{ $name }}</span>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

            <!--begin: Head -->
            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-color: #292f49;)">
{{--            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(assets/admin/media/misc/bg-1.jpg)">--}}
                <div class="kt-user-card__avatar">
                    <img class="kt-hidden" alt="Pic" src="assets/admin/media/users/300_25.jpg" />

                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->

                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-brand">{{ $name }}</span>
                </div>
                <div class="kt-user-card__name">
                    مرحباً بكـ , {{ Auth::guard('admin')->user()->name }}
                </div>
            </div>

            <!--end: Head -->

            <!--begin: Navigation -->
            <div class="kt-notification">
                <a href="{{ route('dashboard.profile') }}" class="kt-notification__item">
                    <div class="kt-notification__item-icon">
                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title kt-font-bold">
                            البروفايل
                        </div>
                        <div class="kt-notification__item-time">
                            تعديل البروفايل
                        </div>
                    </div>
                </a>
                <a href="{{ route('dashboard.password') }}" class="kt-notification__item">
                    <div class="kt-notification__item-icon">
                        <i class="flaticon2-lock kt-font-danger"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title kt-font-bold">
                            كلمة المرور
                        </div>
                        <div class="kt-notification__item-time">
                            تغيير كلمة المرور
                        </div>
                    </div>
                </a>
                <div class="kt-notification__custom kt-space-between">
                    <a href="{{ route('dashboard.logout') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">تسجيل الخروج</a>
                </div>
            </div>

            <!--end: Navigation -->
        </div>
    </div>

    <!--end: User Bar -->
</div>
