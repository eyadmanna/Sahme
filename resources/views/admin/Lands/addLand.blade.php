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
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Add land')</li>
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
            <form method="post" action="{{ route('lands.store') }}" class="form" id="kt_add_land">
                @csrf

                <!--begin::Card - Investor Info-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header pt-8">
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <!--begin::Input-->
                                <select id="investor_id" name="investor_id" aria-label="Select a Language" data-control="select2" data-placeholder="@lang('admin.Investor name')" class="form-select mb-2">
                                    <option></option>
                                    @foreach($investors as $investor)
                                        <option value="{{$investor->id}}">{{$investor->full_name}}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                                <!--begin::Add Button-->
                                <a title="@lang('admin.Add a new investor')" href="#" class="btn btn-icon btn-primary rounded-circle">
                                    <i class="ki-duotone ki-plus fs-2"></i>
                                </a>
                                <!--end::Add Button-->
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

                <!--begin::Card - Land Details-->
                <div class="card card-flush mt-5">
                    <div class="card-header pt-8">
                        <h3>@lang('admin.Land details')</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 mb-15">
                            <div class="col-md-8">
                                <label class="form-label required">@lang('admin.Description of the land')</label>
                               <input class="form-control" id="land_description" name="land_description" type="text">
                            </div>
                        </div>
                        <div class="row g-4 mb-15">
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Province')</label>
                                <select id="province_cd" class="form-select location_province" data-control="select2" name="province_cd">
                                    <option value="" selected>@lang('admin.Select')..</option>
                                    @foreach ($provinces as $val)
                                        <option value="{{ $val->id }}">
                                            {{ $val->{'name_' . app()->getLocale()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" id="cities_block">
                                <label class="form-label required">@lang('admin.City')</label>
                                <select class="form-select location_city" name="city_cd" id="location_cities">
                                    <option value="" selected>@lang('admin.Select')..</option>
                                </select>
                            </div>
                            <div class="col-md-3" id="areas_block">
                                <label class="form-label">@lang('admin.District')</label>
                                <select class="form-select" id="location_areas"  name="district_cd">
                                    <option value="" selected>@lang('admin.Select')..</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Address in detail')</label>
                                <textarea class="form-control" rows="3" name="address" placeholder="@lang('admin.Enter detailed address')"></textarea>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Land area')</label>
                                <input class="form-control" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('admin.Plot Number')</label>
                                <input class="form-control" name="plot_number" type="text" placeholder="@lang('admin.Enter the part number')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('admin.Parcel Number')</label>
                                <input class="form-control" name="parcel_number" type="text" placeholder="@lang('admin.Enter the Voucher number')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Type of land ownership')</label>
                                <select class="form-select" name="ownership_type_cd" data-control="select2" data-placeholder="@lang('admin.Choose the land ownership type')">
                                    <option value="" disabled selected>@lang('admin.Choose the land ownership type')</option>
                                    @foreach($ownership_type as $ownership_types)
                                        <option value="{{$ownership_types->id}}">{{$ownership_types->{'name_'.app()->getLocale()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">
                            <div class="col-md-4">
                                <label class="form-label">@lang('admin.Border')</label>
                                <textarea class="form-control" rows="3" name="borders"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">@lang('admin.Available services')</label>
                                <textarea class="form-control" rows="3" name="services"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">@lang('admin.Asking price')</label>
                                <div class="d-flex gap-2">
                                    <input type="number" class="form-control" name="price" placeholder="@lang('admin.Enter the price')" style="text-align: right; direction: rtl;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->

                <!--begin::Card - Map-->
                <div class="card card-flush mt-5">
                    <div class="card-header pt-8">
                        <h3>@lang('admin.Address on map')</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-5">
                                <div id="map" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"></div>
                            </div>
                            <div class="col-md-4 d-flex flex-column justify-content-center gap-3">
                                <div>
                                    <label class="form-label fw-bold required">@lang('admin.Latitude')</label>
                                    <input type="text" id="lat" name="lat" class="form-control" placeholder="@lang('admin.Latitude')" value="31.5012">
                                </div>
                                <div>
                                    <label class="form-label fw-bold required">@lang('admin.Longitude')</label>
                                    <input type="text" id="long" name="long" class="form-control" placeholder="@lang('admin.Longitude')" value="34.4663">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->

                <!--begin::Actions-->
                <div class="row mt-10">
                    <div class="col-md-9 offset-md-3">
                        <button type="button" class="btn btn-light me-3">@lang('admin.Cancel')</button>
                        <button id="submit" type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">@lang('admin.Submit')</span>
                            <span class="indicator-progress">@lang('admin.Please wait...')
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
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
    @include("admin.Lands.Partial.addLand_js")

@endsection

