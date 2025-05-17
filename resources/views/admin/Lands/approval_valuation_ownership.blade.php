@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Adding land for investment')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="index.html" class="text-gray-600 text-hover-primary">@lang('admin.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Land management')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Show lands')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.View land')</li>
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
    <div id="kt_content_container_land" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            @include('admin.Lands.components.data_land')
            <form method="post" action="{{ route('lands.approval_legal_ownership', $land->id) }}" class="form" id="kt_approval_legal_land" enctype="multipart/form-data">
                @csrf

                <!--begin::Actions-->
                <div class="row mt-10">
                    <div class="col-md-9 offset-md-3">
                        <button data-land-id="{{ $land->id }}" type="submit" name="action" value="approved" class="btn btn-primary" data-kt-lands-legal-action="submit">
                            <span class="indicator-label">@lang('admin.Land adoption')</span>
                            <span class="indicator-progress">@lang('admin.Please wait...')
                                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <button data-land-id="{{ $land->id }}" type="submit" name="action" value="rejected" class="btn btn-danger" data-kt-lands-legal-action="submit">
                            <span class="indicator-label">@lang('admin.Refusal to approve the land')</span>
                            <span class="indicator-progress">@lang('admin.Please wait...')
                                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <button type="button" class="btn btn-light me-3" style="margin-inline-start: inherit">@lang('admin.Discard')</button>

                    </div>
                </div>
                <!--end::Actions-->
            </form>

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Lands.Partial.approval_legal_ownership_js")

@endsection

