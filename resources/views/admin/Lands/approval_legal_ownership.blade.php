@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Legal approval of the land')</h1>
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
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Evaluation of the legal partner')</li>
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
            <!--begin::Card - Map-->
            <div class="card card-flush mt-5">
                <div class="card-header pt-8">
                    <h3>@lang('admin.Credentials')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6>@lang('admin.Land ownership certification files')</h6>
                        </div>
                        <!-- Dropzone area -->
                        <div class="col-md-6">
                            <!--begin::Form-->
                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Dropzone-->
                                    <div class="dropzone" id="kt_dropzonejs_example_1">
                                        <!--begin::Message-->
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                                            <!--begin::Info-->
                                            <div class="ms-4">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">@lang('admin.Drop files here or click to upload.')</h3>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                    </div>
                                    <!--end::Dropzone-->
                                </div>
                                <!--end::Input group-->
                            <!--end::Form-->
                        </div>
                    </div>
                    <div class="row mt-7">
                        <div class="col-md-3">
                            <h6>@lang('admin.Land ownership approval notes')</h6>
                        </div>
                        <!-- Dropzone area -->
                        <div class="col-md-6">
                            <textarea class="form-control" name="legal_notes">{{$land->legal_notes}}</textarea>
                        </div>
                    </div>
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
                            <button type="button" class="btn btn-light me-3"  data-kt-lands-legal-action="cancel" style="margin-inline-start: inherit">@lang('admin.Discard')</button>

                        </div>
                    </div>
                    <!--end::Actions-->
                </div>
            </div>
            <!--end::Card-->

            </form>

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Lands.Partial.general_land_js")
    @include("admin.Lands.Partial.approval_legal_ownership_js")

@endsection

