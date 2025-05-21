@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Project evaluation by engineering consultant')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="index.html" class="text-gray-600 text-hover-primary">@lang('admin.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Projects')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Project evaluation by engineering consultant')</li>
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
    <div id="kt_content_container_project" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
                <!--begin::Card - Land Info-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header pt-8">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <!--begin::Input-->
                                <h3>@lang('admin.Land details')</h3>
                                <!--end::Input-->
                            </div>
                        </div>

                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <div class="d-flex align-items-center gap-2">
                                <!--begin::Input-->
                                <select id="land_id" disabled name="land_id" aria-label="Select a Language" data-control="select2" data-placeholder="@lang('admin.Land details')" class="form-select mb-2">
                                    <option  data-lat="{{$land->lat}}"
                                             data-long="{{$land->long}}" data-investor_id="{{$land->investor_id}}" value="{{$land->id}}"  selected >
                                        {{ Str::words($land->land_description, 3, '...') }}
                                        - {{$land->area}} - {{$land->investor->full_name}}
                                    </option>
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Form-->
                        <!-- Investor details will be loaded here -->
                        <div class="mt-10" id="land_details" style="display: none;">
                            <!-- content will be injected here by AJAX -->
                        </div>

                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card - Map-->
                <div class="card card-flush mt-5" id="map_card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('admin.Land Location Map')</h3>
                    </div>
                    <div class="card-body">
                        <div id="map" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"></div>
                        <input type="text" id="lat" name="lat" hidden>
                        <input type="text" id="long" name="long" hidden>
                    </div>
                </div>
                <!--end::Card-->
                <!--begin::Card - Land Info-->
                <div class="card card-flush mt-5">
                    <!--begin::Card header-->
                    <div class="card-header pt-8">
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <!--begin::Input-->
                                <h3>@lang('admin.Investor data')</h3>
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Form-->
                        <!-- Investor details will be loaded here -->
                        <div id="investor_details" style="display: none;">
                            <!-- content will be injected here by AJAX -->
                        </div>

                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card - Land Info-->
                <div class="card card-flush mt-5">
                    <!--begin::Card header-->
                    <div class="card-header pt-8">
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <!--begin::Input-->
                                <h3>@lang('admin.Project data')</h3>
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Form-->
                        <div class="row g-4 mb-15">
                            <div class="col-md-6 fv-row">
                                <label disabled class="required form-label">@lang('admin.Project name')</label>
                                <input disabled class="form-control" name="title" value="{{$project->title}}">
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="form-label">@lang('admin.Project description')</label>
                                <textarea disabled row="3" class="form-control" name="description">{{$project->description}}</textarea>
                            </div>
                        </div>
                        <div class="row g-4 mb-15">
                            <div class="col-md-4 fv-row">
                                <label class="required form-label">@lang('admin.Project type')</label>
                                <select disabled name="project_type_cd" class="form-select" data-control="select2" data-placeholder="@lang('admin.Project type')">
                                    <option>{{getlookup($project->project_type_cd)->{'name_' . app()->getLocale()} }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 fv-row">
                                <label class="required form-label">@lang('admin.Project space')</label>
                                <div class="input-group">
                                    <input disabled class="form-control text-start" value="{{$project->area}}" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')">
                                    <span class="input-group-text">م2</span>
                                </div>
                            </div>
                            <div class="col-md-4 fv-row">
                                <label class="required form-label">@lang('admin.Project cost')</label>
                                <div class="input-group">
                                    <input disabled class="form-control text-start" id="project_cost" value="{{$project->project_cost}}" name="project_cost" type="number" placeholder="@lang('admin.Enter The project cost')">
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 mb-15">
                            <div class="col-md-6 fv-row">
                                <label class="required form-label">@lang('admin.Engineering bid opening date')</label>
                                <input disabled type="date" name="offers_start_date" class="form-control text-start" value="{{$project->offers_start_date}}">
                            </div>
                            <div class="col-md-6 fv-row">
                                <label class="required form-label">@lang('admin.Closing date for engineering bids')</label>
                                <input disabled type="date" name="offers_end_date" class="form-control text-start" value="{{$project->offers_end_date}}">
                            </div>
                        </div>
                        <form method="post" action="{{ route('projects.engineering_consultant_evaluation',$project->id) }}" class="form mt-15" id="kt_engineering_consultant_evaluation_project">
                            @csrf
                        <div class="row g-4">
                            <input type="hidden" value="{{$project->id}}" id="project_id" name="project_id">
                            <div class="col-md-3">
                                <h4>@lang('admin.Project evaluation')</h4>
                            </div>
                            <div class="col-md-9 text-end">
                                <button type="button" class="btn btn-light me-3 text-start"  data-kt-project-evaluation-engineering-consultant-action="cancel" style="margin-inline-start: inherit">@lang('admin.Discard')</button>
                                <button data-land-id="{{ $land->id }}" type="submit" name="action" value="no_need_edit" class="btn btn-primary" data-kt-project-evaluation-engineering-consultant-action="submit">
                                    <span class="indicator-label">@lang('admin.No modification required')</span>
                                    <span class="indicator-progress">@lang('admin.Please wait...')
                                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_no_need_edit">@lang('admin.Modification required')</button>


                            </div>
                        </div>
                        </form>

                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            <div class="modal fade" id="kt_modal_no_need_edit" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_modify_price_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('admin.Request to modify a project')</h2>
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
                            <form id="kt_modal_modify_engineering_consultant_evaluation_notes_form" class="form"  method="post" action="{{ route('projects.engineering_consultant_evaluation', $project->id) }}"  enctype="multipart/form-data">
                                @csrf                                            <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_modify_price_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_modify_price_header" data-kt-scroll-wrappers="#kt_modal_modify_price_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">@lang('admin.Modifications required')</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="input-group">
                                            <textarea rows="3" class="form-control" name="engineering_consultant_evaluation_notes" style="text-align: right; direction: rtl;"></textarea>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-10">
                                    <button type="reset" class="btn btn-light me-3" data-kt-project-evaluation-engineering-consultant-notes-action="cancel">@lang('admin.Discard')</button>
                                    <button type="submit" class="btn btn-primary" value="engineering_consultant_evaluation_notes"  data-kt-project-evaluation-engineering-consultant-notes-action="submit">
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
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Projects.Partial.project_evaluation_by_engineering_consultant_js")

@endsection

