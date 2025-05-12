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
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                        <!--begin::Input-->
                        <select name="language" aria-label="Select a Language" data-control="select2" data-placeholder="@lang('admin.Investor name')" class="form-select mb-2">
                            <option></option>
                            <option value="en-gb">English UK - British English</option>
                            <option value="es">Español - Spanish</option>
                            <option value="fil">Filipino</option>
                            <option value="fr">Français - French</option>
                            <option value="ro">Română - Romanian</option>
                            <option value="sk">Slovenčina - Slovak</option>
                            <option value="fi">Suomi - Finnish</option>
                            <option value="sv">Svenska - Swedish</option>
                            <option value="vi">Tiếng Việt - Vietnamese</option>
                            <option value="tr">Türkçe - Turkish</option>
                            <option value="el">Ελληνικά - Greek</option>
                            <option value="bg">Български език - Bulgarian</option>
                            <option value="ru">Русский - Russian</option>
                            <option value="sr">Српски - Serbian</option>
                            <option value="uk">Українська мова - Ukrainian</option>
                            <option value="he">עִבְרִית - Hebrew</option>
                            <option value="ur">اردو - Urdu (beta)</option>
                            <option value="ar">العربية - Arabic</option>
                            <option value="fa">فارسی - Persian</option>
                            <option value="mr">मराठी - Marathi</option>
                            <option value="hi">हिन्दी - Hindi</option>
                            <option value="bn">বাংলা - Bangla</option>
                            <option value="gu">ગુજરાતી - Gujarati</option>
                            <option value="ta">தமிழ் - Tamil</option>
                            <option value="kn">ಕನ್ನಡ - Kannada</option>
                            <option value="th">ภาษาไทย - Thai</option>
                            <option value="ko">한국어 - Korean</option>
                            <option value="ja">日本語 - Japanese</option>
                            <option value="zh-cn">简体中文 - Simplified Chinese</option>
                            <option value="zh-tw">繁體中文 - Traditional Chinese</option>
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
                    <form class="form" id="kt_add_land">
                        <!--begin::Input group-->
                        <div class="fv-row row mb-15">
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex  align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.Mobile number') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">05977545454</label>

                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-3 d-flex  align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.Email') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">admn@gmail.com</label>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.The condition') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">admn@gmail.com</label>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.Registration Date') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">3153153</label>
                            </div>
                            <!--end::Col-->

                            <!-- يمكنك إضافة أعمدة أخرى حسب الحاجة بنفس النمط -->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row row mb-15">
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex  align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.Mobile number') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">05977545454</label>

                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-3 d-flex  align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.Email') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">admn@gmail.com</label>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.The condition') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">admn@gmail.com</label>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex align-items-center mb-5">
                                <h5 class="mb-0">@lang('admin.Registration Date') :</h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">3153153</label>
                            </div>
                            <!--end::Col-->

                            <!-- يمكنك إضافة أعمدة أخرى حسب الحاجة بنفس النمط -->
                        </div>
                        <!--end::Input group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Card-->
            <div class="card card-flush mt-5">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <h3>@lang('admin.Land details')</h3>
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form" id="kt_add_land">
                        <!--begin::Input group-->
                        <div class="fv-row mb-15">
                            <div class="d-flex">
                                <!-- عنصر 1 -->
                                <div class="col-md-3 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
                                    <h6 class="mb-0 required">@lang('admin.Governorate'):</h6>
                                    <select class="form-select w-150px">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>

                                <!-- عنصر 2 -->
                                <div class="col-md-3 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
                                    <h6 class="mb-0 required">@lang('admin.City'):</h6>
                                    <select class="form-select w-150px">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>

                                <!-- عنصر 3 -->
                                <div class="col-md-3 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
                                    <h6 class="mb-0 required">@lang('admin.Area'):</h6>
                                    <select class="form-select w-150px">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                    </select>
                                </div>

                                <!-- عنصر 4 -->
                                <div class="col-md-3 d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
                                    <h6 class="mb-0 required">@lang('admin.Address in detail'):</h6>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row row mb-15">
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex  align-items-center mb-5">
                                <h5 class="mb-0 required">@lang('admin.Land area') </h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">05977545454</label>

                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-3 d-flex  align-items-center mb-5">
                                <h5 class="mb-0 required">@lang('admin.Part number') </h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">admn@gmail.com</label>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex align-items-center mb-5">
                                <h5 class="mb-0 required">@lang('admin.Voucher number') </h5>
                                <label class="ms-2 fs-6 fw-semibold mb-0">admn@gmail.com</label>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex align-items-center mb-5">
                                <h5 class="mb-0 required">@lang('admin.Type of land ownership') </h5>
                                <select class="form-select w-150px">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                </select>
                            </div>
                            <!--end::Col-->

                            <!-- يمكنك إضافة أعمدة أخرى حسب الحاجة بنفس النمط -->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row row mb-15">
                            <!--begin::Col-->
                            <div class="col-md-4 d-flex  align-items-center mb-5">
                                <h5 class="mb-0 required">@lang('admin.Border')</h5>
                                <textarea class="form-control"></textarea>

                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-md-4 d-flex align-items-center mb-5">
                                <h5 class="mb-0 required">@lang('admin.Available services') </h5>
                                <textarea class="form-control"></textarea>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 d-flex align-items-center mb-5">
                                <h5 class="mb-0 required">@lang('admin.Asking price')</h5>
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-1 d-flex align-items-center mb-5">
                                <!--begin::Select-->
                                <select class="form-control form-select" data-mce-placeholder="@lang('admin.Select currency')">
                                    <option value="" disabled selected>@lang('admin.Select currency')</option>
                                    <!-- Add other options here -->
                                    <option value="usd">USD</option>
                                    <option value="eur">EUR</option>
                                </select>
                                <!--end::Select-->
                            </div>



                            <!-- يمكنك إضافة أعمدة أخرى حسب الحاجة بنفس النمط -->
                        </div>
                        <!--end::Input group-->

                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Action buttons-->
            <div class="row mt-10">
                <div class="col-md-9 offset-md-3">
                    <!--begin::Cancel-->
                    <button type="button" class="btn btn-light me-3">Cancel</button>
                    <!--end::Cancel-->
                    <!--begin::Button-->
                    <button type="button" class="btn btn-primary" id="kt_file_manager_settings_submit">
                        <span class="indicator-label">Save</span>
                        <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!--begin::Action buttons-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Lands.Partial.land_list_js")
@endsection

