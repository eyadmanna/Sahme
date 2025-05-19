@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('engineering.add_engineering_partner')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{route('dashboard')}}" class="text-gray-600 text-hover-primary">@lang('admin.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{route('engineering_partners.index')}}" class="text-gray-600 text-hover-primary">
                            @lang('engineering.engineering_partner_management')
                        </a>
                    </li>

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.add_engineering_partner')</li>
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
            <div class="card">
                <div class="card-body">
                    <!--begin::Form-->
                    <form method="POST" class="form w-100" novalidate="novalidate" id="kt_account_form" data-kt-redirect-url="{{ route('engineering.dashboard') }}" action="{{ route('engineering.register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="@lang('engineering.Company Name')" name="company_name" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="@lang('engineering.Mobile')" name="mobile" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-8 " >
                                    <!--begin::Email-->

                                    <select class="form-select location_province"  name="province_cd" data-control="select2" data-placeholder="@lang('engineering.select_province')">
                                        <option value="" selected>@lang('lang.Select')..</option>
                                        @foreach ($data['provinces'] as $val)
                                            <option value="{{ $val->id }}">
                                                {{ $val->{'name_' . app()->getLocale()} }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Email-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8" id="cities_block">
                                    <!--begin::Email-->
                                    <select class="form-select location_city" id="location_cities"  name="city_cd" data-control="select2" data-placeholder="@lang('engineering.select_city')">
                                        <option value="" selected>@lang('lang.Select')..</option>

                                    </select>

                                    <!--end::Email-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8" id="areas_block">
                                    <!--begin::Email-->
                                    <select class="form-select" id="location_areas"  name="district_cd" data-control="select2" data-placeholder="@lang('engineering.select_district')">
                                        <option value="" selected>@lang('lang.Select')..</option>

                                    </select>

                                    <!--end::Email-->
                                </div>
                            </div>
                        </div>

                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="@lang('engineering.Address')" name="address" autocomplete="off" class="form-control bg-transparent" />
                            <!--end::Email-->
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="@lang('engineering.experience_years')" name="experience_years" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8">

                                    <input type="text" placeholder="@lang('engineering.commercial_registration_number')" name="commercial_registration_number" autocomplete="off" class="form-control bg-transparent" />

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8">

                                    <input type="text" placeholder="@lang('engineering.specializations')" name="specializations" autocomplete="off" class="form-control bg-transparent" />

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="@lang('engineering.tax_number')" name="tax_number" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="@lang('admin.Email')" name="email" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-8">
                                    <label for="logo" class="required form-label">@lang('engineering.Logo')</label>
                                    <input type="file"  name="logo" id="logo" autocomplete="off" class="form-control bg-transparent" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8">
                                    <label for="company_profile" class="required form-label">@lang('engineering.company_profile')</label>
                                    <input type="file"  name="company_profile" id="company_profile" autocomplete="off" class="form-control bg-transparent" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8">
                                    <label for="commercial_registration" class="required form-label">@lang('engineering.commercial_registration')</label>
                                    <input type="file"  name="commercial_registration" id="commercial_registration" autocomplete="off" class="form-control bg-transparent" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-8">
                                    <label for="liecence" class="required form-label">@lang('engineering.liecence')</label>
                                    <input type="file"  name="liecence" id="liecence" autocomplete="off" class="form-control bg-transparent" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8">
                                    <label for="tax_record" class="required form-label">@lang('engineering.tax_record')</label>
                                    <input type="file"  name="tax_record" id="tax_record" autocomplete="off" class="form-control bg-transparent" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-8">
                                    <label for="previous_projects" class="required form-label">@lang('engineering.previous_projects')</label>
                                    <input type="file"  name="previous_projects" id="previous_projects" autocomplete="off" class="form-control bg-transparent" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-8" data-kt-password-meter="true">
                                    <!--begin::Wrapper-->
                                    <div class="mb-1">
                                        <!--begin::Input wrapper-->
                                        <div class="position-relative mb-3">
                                            <input class="form-control bg-transparent" type="password" placeholder="@lang('admin.Password')" name="password" autocomplete="off" />
                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="ki-duotone ki-eye-slash fs-2"></i>
												<i class="ki-duotone ki-eye fs-2 d-none"></i>
											</span>
                                        </div>
                                        <!--end::Input wrapper-->
                                        <!--begin::Meter-->
                                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                        </div>
                                        <!--end::Meter-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Hint-->
                                    <div class="text-muted">@lang('admin.Use 8 or more characters with a mix of letters, numbers & symbols.')</div>
                                    <!--end::Hint-->
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-8">
                                    <!--begin::Repeat Password-->
                                    <input placeholder="@lang('admin.Repeat Password')" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Repeat Password-->
                                </div>
                            </div>
                        </div>




                        <!--end::Input group=-->

                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="add_form" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">@lang('admin.Sign up')</span>
                                <!--end::Indicator label-->

                            </button>
                        </div>
                        <!--end::Submit button-->

                    </form>
                    <!--end::Form-->
                </div>
            </div>

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.engineering_partner_management.Partial.create_js")

@endsection

