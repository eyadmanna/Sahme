<script>
    $(document).ready(function () {
        $(document).on("change", "select.location_province", function () {
            var province_id = $(this).val();
            var this_city = $("#location_cities");
            var this_area = $("#location_areas");
            var cities_block = document.querySelector("#cities_block");

            if (!cities_block) {
                console.error("#cities_block not found");
                return;
            }

            // استخدم getInstance أو أنشئ جديد عند الحاجة فقط
            var blockUI = KTBlockUI.getInstance(cities_block) ?? new KTBlockUI(cities_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });

            if (province_id !== '') {
                blockUI.block();
                this_city.empty();
                this_area.empty();

                $.ajax({
                    method: "POST",
                    url: '{{url("/")}}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: province_id, '_token': '{{csrf_token()}}' },
                    success: function (data) {
                        this_city.append(data.children);
                    },
                    complete: function () {
                        blockUI.release();
                    },
                    error: function () {
                        blockUI.release();
                    }
                });
            } else {
                blockUI.release();
            }
        });
        $(document).on("change", "select.location_city", function () {
            var city_id = $(this).val();
            var this_area = $("#location_areas");
            var areas_block = document.querySelector("#areas_block");

            if (!areas_block) {
                console.error("#areas_block not found");
                return;
            }

            var blockUI = KTBlockUI.getInstance(areas_block) ?? new KTBlockUI(areas_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });

            if (city_id !== '') {
                blockUI.block();
                this_area.empty();

                $.ajax({
                    method: "POST",
                    url: '{{url("/")}}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: city_id, '_token': '{{csrf_token()}}' },
                    success: function (data) {
                        this_area.append(data.children);
                    },
                    complete: function () {
                        blockUI.release();
                    },
                    error: function () {
                        blockUI.release();
                    }
                });
            } else {
                blockUI.release();
            }
        });
        let table = $("#kt_table_lands").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('lands.getLands') }}",
                data: function (d) {
                    d.province_cd = $('#province_cd').val();
                    d.location_cities = $('#location_cities').val();
                    d.location_areas = $('#location_areas').val();
                    d.address = $('#address').val();
                    d.ownership_type_cd = $('#ownership_type_cd').val();
                    d.accreditation_status = $('#accreditation_status').val();
                    d.area_from = $('#area_from').val();
                    d.area_to = $('#area_to').val();
                    d.price_from = $('#price_from').val();
                    d.price_to = $('#price_to').val();
                }
            },
            columns: [
                { data: 'investor_name', name: 'investor_name' },
                { data: 'province_cd', name: 'province_cd' },
                { data: 'city_cd', name: 'city_cd' },
                { data: 'valuation_status_cd', name: 'valuation_status_cd' },
                { data: 'legal_status_cd', name: 'legal_status_cd' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                "url": "{{url('/')}}/assets/Arabic.json"
            },
            createdRow: function (row, data, dataIndex) {
                $('td', row).each(function (index) {
                   $(this).addClass('text-center');

                });
            },
            drawCallback: function () {
                if (typeof KTMenu !== 'undefined') {
                    KTMenu.createInstances();
                }
            }
        });
        let searchTimeout;
        $('[data-kt-land-table-filter="search"]').on('keyup', function () {
            clearTimeout(searchTimeout);
            let input = this;

            searchTimeout = setTimeout(function () {
                table.search(input.value).draw();
            }, 300); // delay in milliseconds
        });
        $('.search_btn').on('click', function () {
            table.draw(); // redraw the table with the filter values
        });
        $('.reset_search').on('click', function () {
            $('#filters')[0].reset(); // clear form fields
            // Reset the Select2 value manually
            $('#province_cd').val(null).trigger('change'); // Reset and update UI
            $('#location_cities').val(null).trigger('change');
            $('#location_areas').val(null).trigger('change');
            $('#address').val(null).trigger('change');
            $('#ownership_type_cd').val(null).trigger('change');
            $('#accreditation_status').val(null).trigger('change');
            $('#area_from').val(null).trigger('change');
            $('#area_to').val(null).trigger('change');
            $('#price_from').val(null).trigger('change');
            $('#price_to').val(null).trigger('change');
            table.draw(); // refresh table
        });
    });


</script>
