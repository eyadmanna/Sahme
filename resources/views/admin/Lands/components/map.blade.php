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


