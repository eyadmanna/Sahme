
    <!--begin::Card - Investor Info-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header pt-8">
            <!--begin::Col-->
            <div class="col-md-4">
                <h3>@lang('admin.Investor data')</h3>
                <div class="d-flex align-items-center gap-2">
                    <!--begin::Input-->
                    <select disabled id="investor_id" name="investor_id" aria-label="Select a Language" data-control="select2" data-placeholder="@lang('admin.Investor name')" class="form-select mb-2">
                        <option></option>
                        @foreach($investors as $investor)
                            <option value="{{$investor->id}}" @if($investor->id == $land->investor_id) selected @endif>{{$investor->full_name}}</option>
                        @endforeach
                    </select>
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
    <div class="card card-flush mt-8">
        <!--begin::Card header-->
        <div class="card-header pt-8">
            <div class="col-md-4">
                <h3 class="text-danger">@lang('admin.Land details')</h3>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body">
            <!-- Description -->
            <input type="hidden" value="{{$land->id}}" id="land_id" name="land_id">
            <div class="mb-7">
                <label class="form-label fw-bold">@lang('admin.Description of the land'):</label>
                <div class="form-control form-control-solid bg-light">{{ $land->land_description }}</div>
            </div>

            <!-- Location Info -->
            <div class="row g-4 mb-7">
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.Province'):</label>
                    <div class="form-control form-control-solid bg-light">
                        {{ getlookup($land->province_cd)->{"name_".app()->getLocale()} ?? '---' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.City'):</label>
                    <div class="form-control form-control-solid bg-light">
                        {{ getlookup($land->city_cd)->{"name_".app()->getLocale()} ?? '---' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.District'):</label>
                    <div class="form-control form-control-solid bg-light">
                        {{ getlookup($land->district_cd)->{"name_".app()->getLocale()} ?? '---' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.Address in detail'):</label>
                    <div class="form-control form-control-solid bg-light">{{ $land->address }}</div>
                </div>
            </div>

            <!-- Area and Numbers -->
            <div class="row g-4 mb-7">
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.Land area'):</label>
                    <div class="form-control form-control-solid bg-light">{{ $land->area }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.Plot Number'):</label>
                    <div class="form-control form-control-solid bg-light">{{ $land->parcel_number }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.Parcel Number'):</label>
                    <div class="form-control form-control-solid bg-light">{{ $land->plot_number ?? '---' }}</div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">@lang('admin.Type of land ownership'):</label>
                    <div class="form-control form-control-solid bg-light">
                        {{ getlookup($land->ownership_type_cd)->{'name_'.app()->getLocale()} ?? '-' }}
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">@lang('admin.Border'):</label>
                    <div class="form-control form-control-solid bg-light">{{ $land->borders ?? '---' }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">@lang('admin.Available services'):</label>
                    <div class="form-control form-control-solid bg-light">{{ $land->services ?? '---' }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">@lang('admin.Asking price'):</label>
                    <input class="form-control form-control-solid bg-light number_format" value="{{ $land->price }} $">
                </div>
            </div>
            <div class="row g-4 mt-15">
                <div class="col-md-12">
                    <label class="form-label required">@lang('admin.Land Photos')</label>

                    <div class="row mt-4" id="existing-images">
                        <div id="land_images_container" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px;">
                            @foreach ($land_image as $image)
                                <div id="image-{{ $image->id }}" style="position: relative;">
                                    <div class="card shadow-sm">
                                        <img src="{{ asset('storage/' . $image->file_path) }}" class="card-img-top rounded" style="height: 180px; object-fit: cover;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mt-4" id="preview_images" style="gap: 15px;"></div>

                </div>
            </div>

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->


    <!--begin::Card - Map-->
    <div class="card card-flush mt-5">
        <div class="card-header pt-8">
            <h3 style="color: red">@lang('admin.Address on map')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 mb-5">
                    <div id="map" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"></div>
                </div>
                <div class="col-md-4 d-flex flex-column justify-content-center gap-3">
                    <div>
                        <label class="form-label fw-bold required">@lang('admin.Latitude')</label>
                        <input type="text"  id="lat" name="lat" class="form-control" placeholder="@lang('admin.Latitude')" value="{{$land->lat}}">
                    </div>
                    <div>
                        <label class="form-label fw-bold required">@lang('admin.Longitude')</label>
                        <input type="text" id="long" name="long" class="form-control" placeholder="@lang('admin.Longitude')" value="{{$land->long}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <!--begin::Card - Existing Attachments-->
    <div class="card card-flush mt-5">
        <div class="card-header pt-8">
            <h3 style="color: red">@lang('admin.Existing Attachments')</h3>
        </div>
        <div class="card-body">
            @if($attachments->isEmpty())
                <div class="alert alert-info">
                    @lang('admin.No attachments found.')
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('admin.File')</th>
                            <th>@lang('admin.Description')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($attachments as $attachment)
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                        {{ basename($attachment->file_path) }}
                                    </a>
                                </td>
                                <td>{{ $attachment->file_description ?? '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <!--end::Card-->

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
