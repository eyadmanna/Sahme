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
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Edit land')</li>
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
                                        <option value="{{$investor->id}}" @if($investor->id == $land->investor_id) selected @endif>{{$investor->full_name}}</option>
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
                                <input id="land_id" type="hidden" name="land_id" value="{{$land->id}}">
                                <input class="form-control" id="land_description" value="{{$land->land_description}}" name="land_description" type="text" placeholder="@lang('admin.Enter land description here')">
                            </div>
                        </div>
                        <div class="row g-4 mb-15">
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Province')</label>
                                <select id="province_cd" class="form-select location_province" data-control="select2" name="province_cd" data-placeholder="@lang('engineering.select_province')">
                                    <option value="" selected>@lang('lang.Select')..</option>
                                    @foreach ($provinces as $val)
                                        <option value="{{ $val->id }}" @if($val->id == $land->province_cd) selected @endif>
                                            {{ $val->{'name_' . app()->getLocale()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" id="cities_block">
                                <label class="form-label required">@lang('admin.City')</label>
                                <select class="form-select location_city" name="city_cd" id="location_cities" data-control="select2" data-placeholder="@lang('engineering.select_city')">
                                    <option value="" selected>@lang('lang.Select')..</option>
                                    @foreach ($city as $val)
                                        <option value="{{ $val->id }}" @if($val->id == $land->city_cd) selected @endif>
                                            {{ $val->{'name_' . app()->getLocale()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" id="areas_block">
                                <label class="form-label">@lang('admin.District')</label>
                                <select class="form-select" id="location_areas"  name="district_cd" data-control="select2" data-placeholder="@lang('engineering.select_district')">
                                    <option value="" selected>@lang('lang.Select')..</option>
                                    @foreach ($area as $val)
                                        <option value="{{ $val->id }}" @if($val->id == $land->district_cd) selected @endif>
                                            {{ $val->{'name_' . app()->getLocale()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Address in detail')</label>
                                <textarea class="form-control" rows="3" name="address" placeholder="@lang('admin.Enter detailed address')">{{$land->address}}</textarea>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Land area')</label>
                                <div class="input-group">
                                    <input class="form-control" id="area" value="{{$land->area}}" name="area" type="number" placeholder="@lang('admin.Enter the area')">
                                    <span class="input-group-text">م2</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('admin.Plot Number')</label>
                                <input class="form-control" value="{{$land->plot_number}}" name="plot_number" type="text" placeholder="@lang('admin.Enter the part number')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('admin.Parcel Number')</label>
                                <input class="form-control" value="{{$land->parcel_number}}" name="parcel_number" type="text" placeholder="@lang('admin.Enter the Voucher number')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Type of land ownership')</label>
                                <select class="form-select" name="ownership_type_cd" data-control="select2" data-placeholder="@lang('admin.Choose the land ownership type')">
                                    <option value="" disabled selected>@lang('admin.Choose the land ownership type')</option>
                                    @foreach($ownership_type as $ownership_types)
                                        <option value="{{$ownership_types->id}}" @if($ownership_types->id == $land->ownership_type_cd) selected @endif>{{$ownership_types->{'name_'.app()->getLocale()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">
                            <div class="col-md-4">
                                <label class="form-label">@lang('admin.Border')</label>
                                <textarea class="form-control" rows="3" name="borders" placeholder="@lang('admin.Enter borders of the land here')">{{$land->borders}}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">@lang('admin.Available services')</label>
                                <textarea class="form-control" rows="3" name="services" placeholder="@lang('admin.Enter services of the land here')">{{$land->services}}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">@lang('admin.Asking price')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number_format" value="{{$land->price}}" name="price" placeholder="@lang('admin.Enter the price')" style="text-align: right; direction: rtl;">
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 mb-15">
                            <div class="col-md-12">
                                <label class="form-label required">@lang('admin.Land Photos')</label>
                                <input type="file" id="land_images" class="form-control" name="land_images[]" multiple accept="image/*">

                                {{-- عنصر مخفي سيحمل الصور المحذوفة --}}
                                <input type="hidden" name="deleted_images" id="deleted_images">

                                <div class="row mt-4" id="existing-images">
                                    <div id="land_images_container" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px;">
                                        @foreach ($land_image as $image)
                                            <div id="image-{{ $image->id }}" style="position: relative;">
                                                <div class="card shadow-sm">
                                                    <img src="{{ asset('storage/' . $image->file_path) }}" class="card-img-top rounded" style="height: 180px; object-fit: cover;">
                                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-image-btn" data-id="{{ $image->id }}">
                                                        &times;
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row mt-4" id="preview_images" style="gap: 15px;"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->

                <!--begin::Card - Map-->
                @include('admin.Lands.components.map', ['lat' => $land->latitude, 'lng' => $land->longitude])

                <!--end::Card-->

                <!--begin::Card - Land Details-->
                <div class="card card-flush mt-5">
                    <div class="card-header pt-8">
                        <h3>@lang('admin.Attached Documents')</h3>
                    </div>
                    <div class="card-body">
                        <!-- ✅ Existing Attachments Preview -->
                        @if (!empty($attachments) && $attachments->count())
                            <div class="mb-5">
                                <h5>@lang('admin.Existing Attachments')</h5>
                                <ul class="list-group">
                                    @foreach ($attachments as $attachment)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                                    {{ $attachment->original_name }}
                                                </a>
                                                <br>
                                            </div>
                                            <div>
                                               <span>{{$attachment->file_description}}</span>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <!-- Delete Button -->
                                                <a href="javascript:;" data-id="{{ $attachment->id }}" class="delete-attachment-btn btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!--begin::Repeater-->
                        <div id="kt_docs_repeater_basic">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="kt_docs_repeater_basic">
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label class="form-label">@lang('admin.Attachment')</label>
                                                <input name="land_attachment" type="file" class="form-control mb-2 mb-md-0"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">@lang('admin.Description')</label>
                                                <input name="description" type="text" class="form-control mb-2 mb-md-0"/>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                    <i class="ki-duotone ki-plus fs-3"></i>
                                    Add
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->
                    </div>
                </div>
                <!--end::Card-->

                <!--begin::Actions-->
                <div class="row mt-10">
                    <div class="col-md-9 offset-md-3 text-end">
                        <button type="button" class="btn btn-light me-3" data-kt-lands-action="cancel">@lang('admin.Discard')</button>
                        <button id="submit" type="submit" class="btn btn-primary" data-kt-land-action="submit">
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
    <style>
        #preview_images {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }
        .position-relative {
            position: relative;
        }
    </style>
    <script>
        let deletedImages = [];

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-image-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const imageId = this.dataset.id;

                    // أضف ID للمصفوفة فقط ولا تحذف من قاعدة البيانات
                    deletedImages.push(imageId);
                    console.log('imageId',imageId)
                    console.log('imageId',deletedImages)
                    // احذف الصورة من العرض
                    document.getElementById('image-' + imageId).remove();

                    // حدث القيمة المخفية
                    document.getElementById('deleted_images').value = deletedImages.join(',');
                });
            });
        });
    </script>
    <script>
        let selectedImages = [];

        document.getElementById('land_images').addEventListener('change', function (event) {
            const newFiles = Array.from(event.target.files);

            // أضف الملفات الجديدة إلى المصفوفة الأصلية
            selectedImages = selectedImages.concat(newFiles);

            updatePreview();
        });

        function updatePreview() {
            const preview = document.getElementById('preview_images');
            preview.innerHTML = '';

            selectedImages.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const col = document.createElement('div');
                    col.className = 'col position-relative';
                    col.innerHTML = `
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-2 d-flex align-items-center justify-content-center">
                            <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;" />
                        </div>
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-image" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                    preview.appendChild(col);
                };

                reader.readAsDataURL(file);
            });

            // إعادة إنشاء ملفات input
            const dataTransfer = new DataTransfer();
            selectedImages.forEach(file => dataTransfer.items.add(file));
            document.getElementById('land_images').files = dataTransfer.files;
        }

        // حذف صورة عند الضغط على زر X
        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-image')) {
                const btn = e.target.closest('.remove-image');
                const index = parseInt(btn.getAttribute('data-index'));

                selectedImages.splice(index, 1); // حذف من المصفوفة
                updatePreview(); // إعادة عرض الصور
            }
        });
    </script>

    @include("admin.Lands.Partial.general_land_js")
    @include("admin.Lands.Partial.editLand_js")

@endsection

