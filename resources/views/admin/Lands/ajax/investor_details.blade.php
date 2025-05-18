<div class="fv-row row mb-15">
    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.Mobile number') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">{{ $investor->phone }}</label>
    </div>

    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.Email') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">{{ $investor->email }}</label>
    </div>

    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.The condition') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">{{ $investor->status_cd }}</label>
    </div>

    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.Registration Date') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">
            {{ $investor->created_at ? $investor->created_at->format('Y-m-d') : '' }}
        </label>
    </div>
</div>
<div class="fv-row row mb-15">
    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.Province') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">{{ $investor->governerate_cd }}</label>
    </div>

    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.City') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">{{ $investor->city_cd }}</label>
    </div>

    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.District') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">{{ $investor->district_cd }}</label>
    </div>

    <div class="col-md-3 d-flex align-items-center mb-5">
        <h5 class="mb-0">@lang('admin.Address in detail') :</h5>
        <label class="ms-2 fs-6 fw-semibold mb-0">
            {{ $investor->address }}
        </label>
    </div>
</div>

