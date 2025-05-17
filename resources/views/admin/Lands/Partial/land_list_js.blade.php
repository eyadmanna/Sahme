<script>
    $(document).ready(function () {
        let table = $("#kt_table_lands").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('lands.getLands') }}",
                data: function (d) {
                    d.province_cd = $('#province_cd').val();
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
                    if (index !== 3) { // Actions column to remain right aligned
                        $(this).addClass('text-center');
                    }
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
            table.draw(); // refresh table
        });
    });


</script>
