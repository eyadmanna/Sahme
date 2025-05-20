<div class="fv-row row mb-15">
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Province')</label>
        <div class="text-muted">
            {{ getlookup($land->province_cd)->{'name_'.app()->getLocale()} }}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.City')</label>
        <div class="text-muted">
            {{ getlookup($land->city_cd)->{'name_'.app()->getLocale()} }}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.District')</label>
        <div class="text-muted">
            {{ getlookup($land->district_cd)->{'name_'.app()->getLocale()} }}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label  d-block">@lang('admin.Address in detail')</label>
        <div class="text-muted">
            {{ $land->address }}
        </div>
    </div>
</div>
<div class="fv-row row mb-15">
    <div class="col-md-3 mb-5">
        <label class="form-label  d-block">@lang('admin.Land area')</label>
        <div class="text-muted">
            {{$land->area}}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Plot Number')</label>
        <div class="text-muted">
            {{ $land->area}}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Parcel Number')</label>
        <div class="text-muted">
            {{ $land->parcel_number }}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Type of land ownership')</label>
        <div class="text-muted">
            {{ getlookup($land->ownership_type_cd)->{'name_'.app()->getLocale()} }}
        </div>
    </div>
</div>

<div class="fv-row row mb-15">
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Border')</label>
        <div class="text-muted">
            {{$land->borders}}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Available services')</label>
        <div class="text-muted">
            {{ $land->services}}
        </div>
    </div>
</div>


