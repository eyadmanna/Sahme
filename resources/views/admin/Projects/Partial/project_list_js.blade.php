<script>
    $(document).ready(function () {
        let table = $("#kt_table_projects").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('projects.getProjects') }}",
                data: function (d) {
                    d.province_cd = $('#province_cd').val();
                }
            },
            columns: [
                { data: 'title', name: 'title' },
                { data: 'project_type_cd', name: 'project_type_cd' },
                { data: 'area', name: 'area' },
                { data: 'project_cost', name: 'project_cost' },
                { data: 'offers_start_date', name: 'offers_start_date' },
                { data: 'offers_end_date', name: 'offers_end_date' },
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
            table.draw(); // refresh table
        });
    });


</script>
