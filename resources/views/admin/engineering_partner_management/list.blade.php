@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('engineering.engineering_partner_management')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{route('dashboard')}}" class="text-gray-600 text-hover-primary">@lang('admin.Home')</a>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">@lang('engineering.engineering_partner_management')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="@lang('engineering.Search')" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="collapse" href="#kt_user_view_details">
                                <i class="ki-duotone ki-filter fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i></button>
                            <!--end::Filter-->

                            <!--begin::Add user-->
                            <a href="{{route('engineering_partners.create')}}" class="btn btn-primary" >
                                <i class="ki-duotone ki-plus fs-2"></i>@lang('engineering.add_engineering_partner')</a>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->

                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <div id="kt_user_view_details" class="collapse mb-5">
                    <div class="py-5 px-10">
                        <form class="kt-form kt-form--label-right form-control" id="filters" method="GET" autocomplete="off">

                            <div class="form-group row">
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-control-label">@lang('engineering.Mobile')</label>
                                    <input type="number" class="form-control" id="mobile" name="mobile">
                                </div>

                             </div>

                            <div class="form-group row">
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%" class="btn btn-info search_btn"><i class="la la-search"></i> @lang('admin.Search')</a>
                                </div>
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%" class="btn btn-secondary reset_search"><i class="la la-recycle"></i> @lang('admin.Reset')</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-center min-w-125px">@lang('admin.User')</th>
                            <th class="text-center min-w-125px">@lang('engineering.Mobile')</th>
                            <th class="text-center min-w-125px">@lang('engineering.Status')</th>
                            <th class="text-center min-w-125px">@lang('admin.Joined Date')</th>
                            <th class="text-end min-w-100px">@lang('admin.Actions')</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.engineering_partner_management.Partial.list_js")
@endsection

