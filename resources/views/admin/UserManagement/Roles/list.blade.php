@extends('admin.layouts.master')
<style>
    .permission-group-header {
        background-color: #f9f9f9;
        border-top: 2px solid #0d6efd;
        border-bottom: 1px solid #dee2e6;
        padding: 10px 15px;
        border-radius: 8px 8px 0 0;
    }

    .permission-group-table {
        border: 1px solid #dee2e6;
        border-top: none;
        margin-bottom: 25px;
        border-radius: 0 0 8px 8px;
        background-color: #fff;
    }

    .permission-chunk td {
        padding: 10px 15px;
    }

    .permission-group-wrapper {
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        border-radius: 8px;
        margin-bottom: 24px; /* Add this line */
    }
</style>

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Roles List')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="index.html" class="text-gray-600 text-hover-primary">@lang('admin.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.System settings')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.User and Permission Management')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Roles List')</li>
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
            <!--begin::Row-->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                @foreach($roles as $role)
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <!--begin::Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{$role->name}}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-1">
                                <!--begin::Users-->
                                <div class="fw-bold text-gray-600 mb-5">@lang('admin.Total users with this role:') {{$role->users->count()}}</div>
                                <!--end::Users-->
                                <!--begin::Permissions-->
                                @foreach($role->permissions as $index => $permission)
                                    @if ($index <= 2)
                                        <div class="d-flex flex-column text-gray-600">
                                            <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>{{ __('permission.'.$permission->name) }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-none permission-item d-more">
                                            <span class="bullet bg-primary me-3"></span>{{ __('permission.').$permission->name}}
                                        </div>
                                    @endif
                                @endforeach
                                @if($role->permissions->count() > 3)
                                <div class='d-flex align-items-center py-2'>
                                    <span class='bullet bg-primary me-3'></span>
                                    <em>@lang('admin.and') {{ $role->permissions->count() - 3 }}@lang('admin.Other')</em>
                                </div>
                                @endif

                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap pt-0">
                                <a href="{{url('view-roles/'.$role->id)}}" class="btn btn-light btn-active-primary my-1 me-2">@lang('admin.View Role')</a>
                                <button type="button" data-role-id="{{ $role->id }}" class="btn btn-light btn-active-light-primary my-1 edit-role-btn" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">@lang('admin.Edit Role')</button>
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                @endforeach
                    <!--begin::Add new card-->
                    <div class="ol-md-4">
                        <!--begin::Card-->
                        <div class="card h-md-100">
                            <!--begin::Card body-->
                            <div class="card-body d-flex flex-center">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                    <!--begin::Illustration-->
                                    <img src="{{asset('assets/media/illustrations/sketchy-1/4.png')}}" alt="" class="mw-100 mh-150px mb-7" />
                                    <!--end::Illustration-->
                                    <!--begin::Label-->
                                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">@lang('admin.Add New Role')</div>
                                    <!--end::Label-->
                                </button>
                                <!--begin::Button-->
                            </div>
                            <!--begin::Card body-->
                        </div>
                        <!--begin::Card-->
                    </div>
                    <!--begin::Add new card-->
            </div>
            <!--end::Row-->
            <!--begin::Modals-->
            <!--begin::Modal - Add role-->
            <div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('admin.Add a Role')</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y mx-lg-5 my-7">
                            <!--begin::Form-->
                            <form id="kt_modal_add_role_form" class="form" action="#">
                                <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header" data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">@lang('admin.Role name')</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="@lang('admin.Enter a role name')" name="role_name" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Permissions-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">@lang('admin.Role Permissions')</label>
                                        <!--end::Label-->
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-semibold">
                                                <!--begin::Table row-->
                                                <tr>
                                                    <td class="text-gray-800">@lang('admin.Administrator Access')
                                                        <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="@lang('admin.Allows a full access to the system')">
																			<i class="ki-duotone ki-information fs-7">
																				<span class="path1"></span>
																				<span class="path2"></span>
																				<span class="path3"></span>
																			</i>
																		</span></td>
                                                    <td id="select-all-td" style="cursor: pointer;">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-9 mb-0">
                                                            <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                                                            <span class="form-check-label" for="kt_roles_select_all">@lang('admin.Select all')</span>
                                                        </label>
                                                        <!--end::Checkbox-->
                                                    </td>
                                                </tr>
                                                <!--end::Table row-->
                                                <!--begin::Table row-->
                                                <!--begin::Permission Group Table-->
                                                @foreach($groupedPermissions as $group => $permissions)
                                                    <!-- Group Header with Check All -->
                                                    <tr>
                                                        <td colspan="3" class="fw-bold text-primary fs-6">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span>{{ __('permission.'.$group) ?: 'Ungrouped' }}</span>
                                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                    <input type="checkbox" class="form-check-input check-all-group" data-group="{{ Str::slug($group) }}">
                                                                    <span class="form-check-label">@lang('admin.Select all')</span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @foreach($permissions->chunk(3) as $chunk)
                                                        <tr>
                                                            @foreach($chunk as $permission)
                                                                <td style="width: 33.33%;" class="text-gray-800">
                                                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                        <input class="form-check-input permission-checkbox group-{{ Str::slug($group) }}"
                                                                               type="checkbox"
                                                                               name="permissions[]"
                                                                               value="{{ $permission->name }}"
                                                                            {{ in_array($permission->name, $rolePermissions ?? []) ? 'checked' : '' }}>
                                                                        <span class="form-check-label">{{ __('permission.'.$permission->name) }}</span>
                                                                    </label>
                                                                </td>
                                                            @endforeach
                                                            @for($i = $chunk->count(); $i < 3; $i++)
                                                                <td style="width: 33.33%;"></td>
                                                            @endfor
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                                <!--end::Permission Group Table-->

                                                <!--end::Table row-->
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Permissions-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">@lang('admin.Discard')</button>
                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                        <span class="indicator-label">@lang('admin.Submit')</span>
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
            <!--end::Modal - Add role-->
            <!--begin::Modal - Update role-->
            <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('admin.Update Role')</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y mx-5 my-7">
                            <!--begin::Form-->
                            <form id="kt_modal_update_role_form" class="form" action="#">
                                <input type="hidden" id="edit_role_id" name="role_id" value="">
                                <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">@lang('admin.Role name')</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="@lang('admin.Enter a role name')" name="role_name" value="Developer" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Permissions-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">@lang('admin.Role Permissions')</label>
                                        <!--end::Label-->
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-semibold">
                                                <!--begin::Table row-->
                                                <tr>
                                                    <td class="text-gray-800">@lang('admin.Administrator Access')
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="@lang('admin.Allows a full access to the system')">
																			<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																				<span class="path1"></span>
																				<span class="path2"></span>
																				<span class="path3"></span>
																			</i>
																		</span></td>
                                                    <td>
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                            <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                                                            <span class="form-check-label" for="kt_roles_select_all">@lang('admin.Select all')</span>
                                                        </label>
                                                        <!--end::Checkbox-->
                                                    </td>
                                                </tr>
                                                <!--end::Table row-->

                                                <!--begin::Table row-->
                                                <!--begin::Permission Group Table-->
                                                @foreach($groupedPermissions as $group => $permissions)
                                                    @php
                                                        $firstPermission = $permissions->first();
                                                        $remainingPermissions = $permissions->slice(1);
                                                    @endphp

                                                    <tr><td colspan="3" class="p-0">
                                                            <div class="permission-group-wrapper">
                                                                <div class="permission-group-header d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="fw-bold text-primary">{{ __('permission.'.$group) ?: 'Ungrouped' }}</span>
                                                                        @if($firstPermission)
                                                                            <label class="form-check form-check-sm form-check-custom form-check-solid ms-4">
                                                                                <input class="form-check-input permission-checkbox"
                                                                                       type="checkbox"
                                                                                       name="permissions[]"
                                                                                       value="{{ $firstPermission->name }}"
                                                                                    {{ in_array($firstPermission->name, $rolePermissions ?? []) ? 'checked' : '' }}>
                                                                                <span class="form-check-label">{{ __('permission.'.$firstPermission->name) }}</span>
                                                                            </label>
                                                                        @endif
                                                                    </div>

                                                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                        <input type="checkbox" class="form-check-input check-all-group" data-group="{{ Str::slug($group) }}">
                                                                        <span class="form-check-label">@lang('admin.Select all')</span>
                                                                    </label>
                                                                </div>

                                                                <table class="table table-bordered permission-group-table mb-0">
                                                                    @foreach($remainingPermissions->chunk(3) as $chunk)
                                                                        <tr class="permission-chunk">
                                                                            @foreach($chunk as $permission)
                                                                                <td class="text-gray-800">
                                                                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                                        <input class="form-check-input permission-checkbox group-{{ Str::slug($group) }}"
                                                                                               type="checkbox"
                                                                                               name="permissions[]"
                                                                                               value="{{ $permission->name }}"
                                                                                            {{ in_array($permission->name, $rolePermissions ?? []) ? 'checked' : '' }}>
                                                                                        <span class="form-check-label">{{ __('permission.'.$permission->name) }}</span>
                                                                                    </label>
                                                                                </td>
                                                                            @endforeach
                                                                            @for($i = $chunk->count(); $i < 3; $i++)
                                                                                <td></td>
                                                                            @endfor
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </td></tr>
                                                @endforeach
                                                <!--end::Permission Group Table-->
                                                <!--end::Table row-->

                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Permissions-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-15">
                                    <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">@lang('admin.Discard')</button>
                                    <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                        <span class="indicator-label">@lang('admin.Submit')</span>
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
            <!--end::Modal - Update role-->
            <!--end::Modals-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include('admin.UserManagement.Partial.roles_list')
@endsection
