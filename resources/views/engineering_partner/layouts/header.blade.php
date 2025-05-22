<div id="kt_header" class="header">
    <!--begin::Header top-->
    <div class="header-top d-flex align-items-stretch flex-grow-1">
        <!--begin::Container-->
        <div class="d-flex container-xxl align-items-stretch">
            <!--begin::Brand-->
            <div class="d-flex align-items-center align-items-lg-stretch me-5 flex-row-fluid">
                <!--begin::Heaeder navs toggle-->
                <button class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px ms-n3 me-2" id="kt_header_navs_toggle">
                    <i class="ki-duotone ki-abstract-14 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
                <!--end::Heaeder navs toggle-->
                <!--begin::Logo-->
                <a href="{{route('dashboard')}}" class="d-flex align-items-center">
                    <img alt="Logo" src="{{asset('assets/sahmi/media/logo.jpeg')}}" class="h-25px h-lg-30px" />
                </a>
                <!--end::Logo-->
                <!--begin::Tabs wrapper-->
                <div class="align-self-end overflow-auto" id="kt_brand_tabs">
                    <!--begin::Header tabs wrapper-->
                    <div class="header-tabs overflow-auto mx-4 ms-lg-10 mb-5 mb-lg-0" id="kt_header_tabs" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
                        <!--begin::Header tabs-->
                        <ul class="nav flex-nowrap text-nowrap">
                            @can('Land Section View')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                   data-bs-toggle="tab"
                                   href="#kt_header_navs_tab_1"
                                   aria-selected="{{ request()->routeIs('dashboard') ? 'true' : 'false' }}"
                                   role="tab">إدارة الأراضي</a>
                            </li>
                            @endcan
                            @can('Projects Section View')
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_2">إدارة المشاريع</a>
                            </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_3">إدارة الشركاء الهندسيين</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_4">إدارة المقاولين</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.index', 'roles.index','users.view') ? 'active' : '' }}"
                                   data-bs-toggle="tab"
                                   href="#kt_header_navs_tab_5"
                                   aria-selected="{{ request()->routeIs('users.index', 'roles.index','users.view') ? 'true' : 'false' }}"
                                   role="tab">@lang('admin.System settings')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_6">التقارير </a>
                            </li>
                        </ul>
                        <!--begin::Header tabs-->
                    </div>
                    <!--end::Header tabs wrapper-->
                </div>
                <!--end::Tabs wrapper-->
            </div>
            <!--end::Brand-->
            <!--begin::Topbar-->
            <div class="d-flex align-items-center flex-row-auto">

                <!--begin::Theme mode-->
                <div class="d-flex align-items-center ms-1">
                    <!--begin::Menu toggle-->
                    <a href="#" class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-night-day theme-light-show fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                            <span class="path9"></span>
                            <span class="path10"></span>
                        </i>
                        <i class="ki-duotone ki-moon theme-dark-show fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                    <!--begin::Menu toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-night-day fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
															<span class="path6"></span>
															<span class="path7"></span>
															<span class="path8"></span>
															<span class="path9"></span>
															<span class="path10"></span>
														</i>
													</span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-moon fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-screen fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
														</i>
													</span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Theme mode-->
                <!--begin::User-->
                <div class="d-flex align-items-center ms-1" id="kt_header_user_menu_toggle">
                    <!--begin::User info-->
                    <div class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 ps-2 pe-2 me-n2" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <!--begin::Name-->
                        <div class="d-none d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4">
{{--                            <span class="text-white opacity-75 fs-8 fw-semibold lh-1 mb-1">{{Auth::user()->company_name}}</span>--}}
                            <span class="text-white fs-8 fw-bold lh-1">{{Auth::user()->company_name}}</span>
                        </div>
                        <!--end::Name-->
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px symbol-md-40px">
                            <img src="{{asset(Auth::user()->logo)}}" alt="image" />
                        </div>
                        <!--end::Symbol-->
                    </div>
                    <!--end::User info-->
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{asset(Auth::user()->logo)}}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{auth()->user()->company_name}}
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span></div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{auth()->user()->email}}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{route('engineering.profile')}}" class="menu-link px-5">@lang('engineering.profile')</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
{{--                        <div class="menu-item px-5">--}}
{{--                            <a href="apps/projects/list.html" class="menu-link px-5">--}}
{{--                                <span class="menu-text">My Projects</span>--}}
{{--                                <span class="menu-badge">--}}
{{--														<span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>--}}
{{--													</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <!--end::Menu item-->--}}
{{--                        <!--begin::Menu item-->--}}
{{--                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">--}}
{{--                            <a href="#" class="menu-link px-5">--}}
{{--                                <span class="menu-title">My Subscription</span>--}}
{{--                                <span class="menu-arrow"></span>--}}
{{--                            </a>--}}
{{--                            <!--begin::Menu sub-->--}}
{{--                            <div class="menu-sub menu-sub-dropdown w-175px py-4">--}}
{{--                                <!--begin::Menu item-->--}}
{{--                                <div class="menu-item px-3">--}}
{{--                                    <a href="account/referrals.html" class="menu-link px-5">Referrals</a>--}}
{{--                                </div>--}}
{{--                                <!--end::Menu item-->--}}
{{--                                <!--begin::Menu item-->--}}
{{--                                <div class="menu-item px-3">--}}
{{--                                    <a href="account/billing.html" class="menu-link px-5">Billing</a>--}}
{{--                                </div>--}}
{{--                                <!--end::Menu item-->--}}
{{--                                <!--begin::Menu item-->--}}
{{--                                <div class="menu-item px-3">--}}
{{--                                    <a href="account/statements.html" class="menu-link px-5">Payments</a>--}}
{{--                                </div>--}}
{{--                                <!--end::Menu item-->--}}
{{--                                <!--begin::Menu item-->--}}
{{--                                <div class="menu-item px-3">--}}
{{--                                    <a href="account/statements.html" class="menu-link d-flex flex-stack px-5">Statements--}}
{{--                                        <span class="ms-2 lh-0" data-bs-toggle="tooltip" title="View your statements">--}}
{{--															<i class="ki-duotone ki-information-5 fs-5">--}}
{{--																<span class="path1"></span>--}}
{{--																<span class="path2"></span>--}}
{{--																<span class="path3"></span>--}}
{{--															</i>--}}
{{--														</span></a>--}}
{{--                                </div>--}}
{{--                                <!--end::Menu item-->--}}
{{--                                <!--begin::Menu separator-->--}}
{{--                                <div class="separator my-2"></div>--}}
{{--                                <!--end::Menu separator-->--}}
{{--                                <!--begin::Menu item-->--}}
{{--                                <div class="menu-item px-3">--}}
{{--                                    <div class="menu-content px-3">--}}
{{--                                        <label class="form-check form-switch form-check-custom form-check-solid">--}}
{{--                                            <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />--}}
{{--                                            <span class="form-check-label text-muted fs-7">Notifications</span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!--end::Menu item-->--}}
{{--                            </div>--}}
{{--                            <!--end::Menu sub-->--}}
{{--                        </div>--}}
{{--                        <!--end::Menu item-->--}}
{{--                        <!--begin::Menu item-->--}}
{{--                        <div class="menu-item px-5">--}}
{{--                            <a href="account/statements.html" class="menu-link px-5">My Statements</a>--}}
{{--                        </div>--}}
{{--                        <!--end::Menu item-->--}}
{{--                        <!--begin::Menu separator-->--}}
{{--                        <div class="separator my-2"></div>--}}
{{--                        <!--end::Menu separator-->--}}
{{--                        <!--begin::Menu item-->--}}
{{--                        <div class="menu-item px-5 my-1">--}}
{{--                            <a href="account/settings.html" class="menu-link px-5">Account Settings</a>--}}
{{--                        </div>--}}
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <!-- رابط تسجيل الخروج -->
                            <a href="{{ route('engineering.logout') }}" class="menu-link px-5"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ki-outline ki-logout fs-2 me-2"></i>
                                @lang('engineering.Sign Out')
                            </a>

                            <!-- الفورم المخفي لتنفيذ POST -->
                            <form id="logout-form" action="{{ route('engineering.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                </div>
                <!--end::User -->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header top-->
    <!--begin::Header navs-->
    <div class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0 overflow-hidden overflow-lg-visible" id="kt_header_navs" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_navs_toggle" data-kt-swapper="true" data-kt-swapper-mode="append" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header'}">
        <!--begin::Container-->
        <div class="d-lg-flex container-xxl w-100">
            <!--begin::Wrapper-->
            <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">
                <!--begin::Header tab content-->
                <div class="tab-content" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: false}" data-kt-scroll-height="auto" data-kt-scroll-offset="70px">
                    <!--begin::Tab panel-->
                    @can('Land Section View')
                    <div class="tab-pane fade {{ request()->routeIs('engineering.dashboard') ? 'show active' : '' }}" id="kt_header_navs_tab_1">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-lg-row flex-lg-stack flex-wrap gap-2 px-4 px-lg-0">
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <a class="btn btn-sm btn-light-primary" href="apps/ecommerce/catalog/products.html">عرض الأراضي</a>
                                <a class="btn btn-sm btn-light-warning" href="apps/subscriptions/view.html">الشركاء القانونيين </a>
                                <a class="btn btn-sm btn-light-info" href="apps/subscriptions/view.html">المثمنين العقاريين  </a>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    @endcan()
                    <!--end::Tab panel-->
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_2">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-lg-row flex-lg-stack flex-wrap gap-2 px-4 px-lg-0">
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <a class="btn btn-sm btn-light-primary" href="documentation/base/forms/controls.html">إضافة مشروع جديد</a>
                                <a class="btn btn-sm btn-light-success" href="documentation/base/forms/advanced.html">عرض المشاريع</a>
                                <a class="btn btn-sm btn-light-danger" href="documentation/base/forms/floating-labels.html"> تقييم المشاريع</a>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Tab panel-->
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_3">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-lg-row flex-lg-stack flex-wrap gap-2 px-4 px-lg-0">
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <a class="btn btn-sm btn-light-primary" href="{{route('users.index')}}">عرض الشركاء الهندسيين </a>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Tab panel-->
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_4">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-lg-row flex-lg-stack flex-wrap gap-2 px-4 px-lg-0">
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <a class="btn btn-sm btn-light-primary" href="apps/ecommerce/catalog/products.html">عرض المقاولين</a>
                                <a class="btn btn-sm btn-light-danger" href="apps/file-manager/folders.html"> إدارة عروض أسعار المقاولين</a>
                                <a class="btn btn-sm btn-light-info" href="apps/subscriptions/view.html"> مراحل تنفيذ المشاريع</a>
                                <a class="btn btn-sm btn-light-info" href="apps/subscriptions/view.html">   </a>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Tab panel-->


                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_6">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-lg-row flex-lg-stack flex-wrap gap-2 px-4 px-lg-0">
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <a class="btn btn-sm btn-light-primary" href="apps/ecommerce/catalog/products.html">eCommerce</a>
                                <a class="btn btn-sm btn-light-danger" href="apps/file-manager/folders.html">File Manager</a>
                            </div>
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <a class="btn btn-sm btn-light-info" href="apps/subscriptions/view.html">More Apps</a>
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Tab panel-->
                </div>
                <!--end::Header tab content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header navs-->
</div>
