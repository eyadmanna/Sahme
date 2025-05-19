
    <!--begin::Card - Investor Info-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header pt-8">
            <!--begin::Col-->
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <!--begin::Input-->
                    <select disabled id="investor_id" name="investor_id" aria-label="Select a Language" data-control="select2" data-placeholder="@lang('admin.Investor name')" class="form-select mb-2">
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
            <h3 style="color: red">@lang('admin.Land details')</h3>
        </div>
        <div class="card-body">
            <div class="row g-4 mb-15">
                <div class="col-md-3">
                    <h6>@lang('admin.Description of the land'):</h6>
                </div>
                <div class="col-md-6">
                    <input id="land_id" type="hidden" name="land_id" value="{{$land->id}}">
                    <span id="land_description" name="land_description" type="text">{{$land->land_description}}</span>
                </div>
            </div>

            <div class="row g-4 mb-15">
                    <div class="col-md-3 d-flex">
                        <h6 class="mb-0 me-5">@lang('admin.Province'):</h6>
                        <span>{{ getlookup($land->province_cd)->{"name_".app()->getLocale()} ?? '-' }}</span>
                    </div>
                    <div class="col-md-3 d-flex">
                        <h6 class="mb-0 me-5">@lang('admin.City'):</h6>
                        <span>{{ getlookup($land->city_cd)->{"name_".app()->getLocale()} ?? '-' }}</span>
                    </div>
                    <div class="col-md-3 d-flex">
                        <h6 class="mb-0 me-5">@lang('admin.District'):</h6>
                        <span>{{ getlookup($land->district_cd)->{"name_".app()->getLocale()} ?? '-' }}</span>
                    </div>
                    <div class="col-md-3 d-flex">
                        <h6 class="mb-0 me-5">@lang('admin.Address in detail'):</h6>
                        <span>{{ $land->address}}</span>
                    </div>
            </div>

            <div class="row g-4 mb-15">
                <div class="col-md-3 d-flex">
                    <h6 class="mb-0 me-5">@lang('admin.Land area'):</h6>
                    <span>{{ $land->area}}</span>
                </div>
                <div class="col-md-3 d-flex">
                    <h6 class="mb-0 me-5">@lang('admin.Plot Number'):</h6>
                    <span>{{ $land->parcel_number}}</span>
                </div>
                <div class="col-md-3 d-flex">
                    <h6 class="mb-0 me-5">@lang('admin.Parcel Number'):</h6>
                    <span>{{ $land->plot_number}}</span>
                </div>
                <div class="col-md-3 d-flex">
                    <h6 class="mb-0 me-5">@lang('admin.Type of land ownership'):</h6>
                    <span>{{ getlookup($land->ownership_type_cd)->{'name_'.app()->getLocale()} ?? '-'}}</span>
                </div>
            </div>

            <div class="row g-4 mb-15">
                <div class="col-md-3 d-flex">
                    <h6 class="mb-0 me-5">@lang('admin.Border'):</h6>
                    <span>{{ $land->borders}}</span>
                </div>
                <div class="col-md-3 d-flex">
                    <h6 class="mb-0 me-5">@lang('admin.Available services'):</h6>
                    <span>{{ $land->services}}</span>
                </div>
                <div class="col-md-3 d-flex">
                    <h6 class="mb-0 me-5">@lang('admin.Asking price'):</h6>
                    <span>{{ $land->price}} $</span>
                </div>

            </div>
        </div>
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

