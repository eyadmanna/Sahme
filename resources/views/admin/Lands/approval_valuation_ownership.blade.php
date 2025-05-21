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
            <div class="card card-flush mt-5">
                <div class="card-body">
                    <form method="post" action="{{ route('lands.approval_legal_ownership', $land->id) }}" class="form" id="kt_approval_valuation_land" enctype="multipart/form-data">
                        @csrf

                        <!--begin::Actions-->
                        <div class="row mt-10">
                            <div class="col-md-3 d-flex">
                                <h2 class="mb-0 me-5">@lang('admin.Asking price')</h2>
                                <h6 style="color: green">{{ $land->price}}</h6>
                            </div>
                            <div class="col-md-9 offset-md-3 text-end">
                                <button type="button" class="btn btn-light me-3"  data-kt-valuation-approval-action="cancel" style="margin-inline-start: inherit">@lang('admin.Discard')</button>

                                <button data-land-id="{{ $land->id }}" type="submit" name="action" value="approved" class="btn btn-primary" data-kt-valuation-approval-action="submit">
                                    <span class="indicator-label">@lang('admin.Price adoption')</span>
                                    <span class="indicator-progress">@lang('admin.Please wait...')
                                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_modify_price">@lang('admin.Request to modify the price')</button>

                            </div>
                        </div>
                        <!--end::Actions-->
                    </form>
                </div>
            </div>

        </div>
        <!--end::Post-->
        <div class="modal fade" id="kt_modal_modify_price" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_modify_price_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">@lang('admin.Request to modify the price')</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body px-5 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_modify_price_form" class="form"  method="post" action="{{ route('lands.approval_legal_ownership', $land->id) }}"  enctype="multipart/form-data">
                            @csrf                                            <!--begin::Scroll-->
                            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_modify_price_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_modify_price_header" data-kt-scroll-wrappers="#kt_modal_modify_price_scroll" data-kt-scroll-offset="300px">
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">@lang('admin.Asking price')</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <input type="number" class="form-control" disabled value="{{$land->price}}" name="price" style="text-align: right; direction: rtl;">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">@lang('admin.Valuation price')</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{$land->valuation_price}}" name="valuation_price" style="text-align: right; direction: rtl;">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">@lang('admin.Appraisal notes')</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea name="valuation_notes" class="form-control form-control-solid mb-3 mb-lg-0">{{$land->valuation_notes}}</textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->
                            <!--begin::Actions-->
                            <div class="text-center pt-10">
                                <button type="reset" class="btn btn-light me-3" data-kt-valuation-modify-price-action="cancel">@lang('admin.Discard')</button>
                                <button type="submit" class="btn btn-primary" value="modify_price"  data-kt-valuation-modify-price-action="submit">
                                    <span class="indicator-label">@lang('admin.Send a modification request')</span>
                                    <span class="indicator-progress">@lang('admin.Please wait...')
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>

    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Lands.Partial.general_land_js")
    @include("admin.Lands.Partial.approval_valuation_ownership")

@endsection

