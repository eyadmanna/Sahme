
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
                <div class="col-md-3">
                    <label class="form-label required">@lang('admin.Province')</label>
                    <select id="province_cd" class="form-select location_province" data-control="select2" name="province_cd">
                        <option value="" selected>@lang('admin.Select')..</option>
                        @foreach ($provinces as $val)
                            <option value="{{ $val->id }}" @if($val->id == $land->province_cd) selected @endif>
                                {{ $val->{'name_' . app()->getLocale()} }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3" id="cities_block">
                    <label class="form-label required">@lang('admin.City')</label>
                    <select class="form-select location_city" name="city_cd" id="location_cities">
                        <option value="" selected>@lang('admin.Select')..</option>
                        @foreach ($city as $val)
                            <option value="{{ $val->id }}" @if($val->id == $land->city_cd) selected @endif>
                                {{ $val->{'name_' . app()->getLocale()} }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3" id="areas_block">
                    <label class="form-label">@lang('admin.District')</label>
                    <select class="form-select" id="location_areas"  name="district_cd">
                        <option value="" selected>@lang('admin.Select')..</option>
                        @foreach ($area as $val)
                            <option value="{{ $val->id }}" @if($val->id == $land->district_cd) selected @endif>
                                {{ $val->{'name_' . app()->getLocale()} }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label required">@lang('admin.Address in detail')</label>
                    <textarea class="form-control" rows="3" name="address" placeholder="@lang('admin.Enter detailed address')">
                                    {{$land->address}}
                                </textarea>
                </div>
            </div>

            <div class="row g-4 mb-15">
                <div class="col-md-3">
                    <label class="form-label required">@lang('admin.Land area')</label>
                    <input class="form-control"  value="{{$land->area}}" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')">
                </div>
                <div class="col-md-3">
                    <label class="form-label">@lang('admin.Plot Number')</label>
                    <input class="form-control" value="{{$land->plot_number}}" name="plot_number" type="text" placeholder="@lang('admin.Enter the part number')">
                </div>
                <div class="col-md-3">
                    <label class="form-label">@lang('admin.Parcel Number')</label>
                    <input class="form-control" value="{{$land->parcel_number}}"  name="parcel_number" type="text" placeholder="@lang('admin.Enter the Voucher number')">
                </div>
                <div class="col-md-3">
                    <label class="form-label required">@lang('admin.Type of land ownership')</label>
                    <select class="form-select" name="ownership_type_cd" data-control="select2" data-placeholder="@lang('admin.Choose the land ownership type')">
                        <option value="" disabled selected>@lang('admin.Choose the land ownership type')</option>
                        @foreach($ownership_type as $ownership_types)
                            <option value="{{$ownership_types->id}}"@if($ownership_types->id == $land->ownership_type_cd) selected @endif>{{$ownership_types->{'name_'.app()->getLocale()} }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-4 mb-15">
                <div class="col-md-4">
                    <label class="form-label">@lang('admin.Border')</label>
                    <textarea class="form-control" rows="3" name="borders">
                                    {{$land->borders}}
                                </textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">@lang('admin.Available services')</label>
                    <textarea class="form-control" rows="3" name="services">
                                  {{$land->services}}
                                </textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label required">@lang('admin.Asking price')</label>
                    <div class="d-flex gap-2">
                        <input type="number" class="form-control" value="{{$land->price}}" name="price" placeholder="@lang('admin.Enter the price')" style="text-align: right; direction: rtl;">
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
