@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('engineering.profile')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{route('engineering.dashboard')}}" class="text-gray-600 text-hover-primary">@lang('engineering.home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.profile')</li>
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
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{asset($user->logo)}}" alt="image" />
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{$user->company_name}}</a>
                                        @if($user->isApproved())
                                            <a href="#">
                                                <i class="ki-duotone ki-verify fs-1 text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        @endif

                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>{{$user->specializations}}</a>
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-geolocation fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>{{$user->full_address}}</a>
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-sms fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>{{$user->email}}</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->

                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Earnings')</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="80">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Projects')</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Success Rate')</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Progress-->
                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                        <span class="fw-semibold fs-6 text-gray-500">@lang('engineering.Profile Compleation')</span>
                                        <span class="fw-bold fs-6">50%</span>
                                    </div>
                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <!--end::Progress-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->routeIs('engineering_partners.profile',$user->id)  ? 'active' : '' }}" href="{{route('engineering_partners.profile',$user->id) }}">@lang('engineering.Overview')</a>
                        </li>
                        <!--end::Nav item-->
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ request()->routeIs('engineering_partners.settings',$user->id) ? 'active' : '' }}" href="{{ route('engineering_partners.settings',$user->id) }}">
                                @lang('engineering.Settings')
                            </a>
                        </li>
                        <!--end::Nav item-->

                    </ul>
                    <!--begin::Navs-->
                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Basic info-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">@lang('engineering.Profile Details')</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_account_profile_details_form" method="post" action="javascript:void(0)"  class="form">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">@lang('engineering.Logo')</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{asset('assets/media/svg/avatars/blank.svg')}}')">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{asset($user->logo)}}')"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="@lang('engineering.Change Logo')">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->


                                    </div>
                                    <!--end::Image input-->
                                    <!--begin::Hint-->
                                    <div class="form-text">@lang('engineering.Allowed file types: png, jpg, jpeg.')</div>
                                    <!--end::Hint-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">@lang('engineering.Company Name')</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="company_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="@lang('engineering.Company Name')" value="{{$user->company_name}}" />
                                        </div>
                                        <!--end::Col-->

                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">@lang('engineering.Mobile')</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="mobile" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.Mobile')" value="{{$user->mobile}}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">@lang('engineering.select_province')</label>
                                <!--end::Label-->
                                <div class="col-lg-2">
                                    <select class=" form-select location_province" id="location_province"  name="province_cd" data-control="select2" data-placeholder="@lang('engineering.select_province')">
                                        <option value="" selected>@lang('lang.Select')..</option>
                                        @foreach ($data['provinces'] as $val)
                                            <option value="{{ $val->id }}" >
                                                {{ $val->{'name_' . app()->getLocale()} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-lg-1 col-form-label required fw-semibold fs-6">@lang('engineering.select_city')</label>
                                <div class="col-lg-2" id="cities_block">
                                    <!--begin::Email-->
                                    <select class="form-select location_city" id="location_cities"  name="city_cd" data-control="select2" data-placeholder="@lang('engineering.select_city')">
                                        <option value="" selected>@lang('lang.Select')..</option>

                                    </select>

                                    <!--end::Email-->
                                </div>
                                <label class="col-lg-1 col-form-label required fw-semibold fs-6">@lang('engineering.select_district')</label>
                                <div class="col-lg-2" id="areas_block">
                                    <!--begin::Email-->
                                    <select class="form-select" id="location_areas"  name="district_cd" data-control="select2" data-placeholder="@lang('engineering.select_district')">
                                        <option value="" selected>@lang('lang.Select')..</option>
                                    </select>

                                 </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.Address')</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="address" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.Address')" value="{{$user->address}}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.experience_years')</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="experience_years" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.experience_years')" value="{{$user->experience_years}}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.tax_number')</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="tax_number" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.tax_number')" value="{{$user->tax_number}}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.commercial_registration_number')</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="commercial_registration_number" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.commercial_registration_number')" value="{{$user->commercial_registration_number}}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.specializations')</span>

                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="specializations" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.specializations')" value="{{$user->specializations}}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row fv-row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.company_profile')</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-4 fv-row">
                                    <input type="file" name="company_profile" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.company_profile')"  />
                                </div>
                                <!--end::Col-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.commercial_registration')</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-4 fv-row">
                                    <input type="file" name="commercial_registration" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.commercial_registration')"  />
                                </div>
                                <!--end::Col-->

                            </div>
                            <div class="row fv-row mb-6">

                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.liecence')</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-4 fv-row">
                                    <input type="file" name="liecence" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.liecence')"  />
                                </div>
                                <!--end::Col-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.tax_record')</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-4 fv-row">
                                    <input type="file" name="tax_record" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.tax_record')"  />
                                </div>
                                <!--end::Col-->

                            </div>
                            <div class="row fv-row mb-6">


                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">@lang('engineering.previous_projects')</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-4 fv-row">
                                    <input type="file" name="previous_projects" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.previous_projects')"  />
                                </div>
                            </div>
                            <!--end::Input group-->

                        </div>
                        <!--end::Card body-->
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                             <button type="submit" class="btn btn-primary" id="add_form">@lang('engineering.Save Changes')</button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Basic info-->
            <!--begin::Sign-in Method-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">@lang('engineering.Sign-in Method')</h3>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_signin_method" class="collapse show">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">

                        <!--begin::Password-->
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <!--begin::Label-->
                            <div id="kt_signin_password">
                                <div class="fs-6 fw-bold mb-1">@lang('admin.Password')</div>
                                <div class="fw-semibold text-gray-600">************</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Edit-->
                            <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                <!--begin::Form-->
                                <form id="kt_signin_change_password" class="form" novalidate="novalidate">
                                    <div class="row mb-1">
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">@lang('engineering.Current Password')</label>
                                                <input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="newpassword" class="form-label fs-6 fw-bold mb-3">@lang('engineering.New Password')</label>
                                                <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">@lang('engineering.Confirm New Password')</label>
                                                <input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassword" id="confirmpassword" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-text mb-5">@lang('engineering.alert_password')</div>
                                    <div class="d-flex">
                                        <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">@lang('engineering.Update Password')</button>
                                        <button id="kt_password_cancel" type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6">@lang('engineering.Cancel')</button>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Edit-->
                            <!--begin::Action-->
                            <div id="kt_signin_password_button" class="ms-auto">
                                <button class="btn btn-light btn-active-light-primary">@lang('engineering.Reset Password')</button>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--end::Password-->
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-shield-tick fs-2tx text-primary me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                <!--begin::Content-->
                                <div class="mb-3 mb-md-0 fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">@lang('engineering.Secure Your Account')</h4>
                                    <div class="fs-6 text-gray-700 pe-7">@lang('engineering.Two-factor')</div>
                                </div>
                                <!--end::Content-->
                                <!--begin::Action-->
                                <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#kt_modal_two_factor_authentication">@lang('engineering.Enable')</a>
                                <!--end::Action-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Sign-in Method-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
    <!--begin::Modal - Two-factor authentication-->
    <div class="modal fade" id="kt_modal_two_factor_authentication" tabindex="-1" aria-hidden="true">
        <!--begin::Modal header-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header flex-stack">
                    <!--begin::Title-->
                    <h2>@lang('engineering.Choose An Authentication Method')</h2>
                    <!--end::Title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y pt-10 pb-15 px-lg-17">
                    <!--begin::Options-->
                    <div data-kt-element="options">
                        <!--begin::Notice-->
                        <p class="text-muted fs-5 fw-semibold mb-10">@lang('engineering.Two Factor Explanation')</p>
                        <!--end::Notice-->

                        <!--begin::Wrapper-->
                        <div class="pb-10">
                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="auth_option" value="apps" checked="checked" id="kt_modal_two_factor_authentication_option_1" />
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="kt_modal_two_factor_authentication_option_1">
                                <i class="ki-duotone ki-setting-2 fs-4x me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">@lang('engineering.Authenticator Apps')</span>
                                <span class="text-muted fw-semibold fs-6">@lang('engineering.Authenticator Description')</span>
                            </span>
                            </label>
                            <!--end::Option-->

                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="auth_option" value="sms" id="kt_modal_two_factor_authentication_option_2" />
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="kt_modal_two_factor_authentication_option_2">
                                <i class="ki-duotone ki-message-text-2 fs-4x me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">SMS</span>
                                <span class="text-muted fw-semibold fs-6">@lang('engineering.SMS Description')</span>
                            </span>
                            </label>
                            <!--end::Option-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Action-->
                        <button class="btn btn-primary w-100" data-kt-element="options-select">@lang('engineering.Continue')</button>
                        <!--end::Action-->
                    </div>
                    <!--end::Options-->

                    <!--begin::Apps-->
                    <div class="d-none" data-kt-element="apps">
                        <h3 class="text-gray-900 fw-bold mb-7">@lang('engineering.Authenticator Apps')</h3>
                        <div class="text-gray-500 fw-semibold fs-6 mb-10">@lang('engineering.App Instructions')
                            <div class="pt-5 text-center">
                                <img src="assets/media/misc/qr.png" alt="" class="mw-150px" />
                            </div>
                        </div>

                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
                            <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-700">@lang('engineering.Manual Entry')
                                        <div class="fw-bold text-gray-900 pt-2">KBSS3QDAAFUMCBY63YCKI5WSSVACUMPN</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form data-kt-element="apps-form" class="form" action="#">
                            <div class="mb-10 fv-row">
                                <input type="text" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.Enter Code')" name="code" />
                            </div>
                            <div class="d-flex flex-center">
                                <button type="reset" data-kt-element="apps-cancel" class="btn btn-light me-3">@lang('engineering.Cancel')</button>
                                <button type="submit" data-kt-element="apps-submit" class="btn btn-primary">
                                    <span class="indicator-label">@lang('engineering.Submit')</span>
                                    <span class="indicator-progress">@lang('engineering.Please Wait')...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--end::Apps-->

                    <!--begin::SMS-->
                    <div class="d-none" data-kt-element="sms">
                        <h3 class="text-gray-900 fw-bold fs-3 mb-5">@lang('engineering.SMS Verify Title')</h3>
                        <div class="text-muted fw-semibold mb-10">@lang('engineering.SMS Instruction')</div>
                        <form data-kt-element="sms-form" class="form" action="#">
                            <div class="mb-10 fv-row">
                                <input type="text" class="form-control form-control-lg form-control-solid" placeholder="@lang('engineering.Enter Mobile')" name="mobile" />
                            </div>
                            <div class="d-flex flex-center">
                                <button type="reset" data-kt-element="sms-cancel" class="btn btn-light me-3">@lang('engineering.Cancel')</button>
                                <button type="submit" data-kt-element="sms-submit" class="btn btn-primary">
                                    <span class="indicator-label">@lang('engineering.Submit')</span>
                                    <span class="indicator-progress">@lang('engineering.Please Wait')...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--end::SMS-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal header-->
    </div>
    <!--end::Modal - Two-factor authentication-->


@endsection
@section('js')
{{--    <script src="{{asset('assets/js/custom/account/settings/signin-methods.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/custom/account/settings/profile-details.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/custom/account/settings/deactivate-account.js')}}"></script>--}}
<script src="{{asset('assets/js/custom/utilities/modals/two-factor-authentication.js')}}"></script>

{{--    <script src="{{asset('assets/js/custom/pages/user-profile/general.js')}}"></script>--}}
@include('admin.engineering_partner_management.partial.profile_settings_js')


@endsection
