<script>
    $(document).ready(function () {
        let table = $("#kt_table_projects").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('projects.getProjects') }}",
                data: function (d) {
                    d.project_type_cd = $('#project_type_cd').val();
                }
            },
            columns: [
                { data: 'title', name: 'title' },
                { data: 'project_type_cd', name: 'project_type_cd' },
                { data: 'project_status_cd', name: 'project_status_cd' },
                { data: 'engineering_consultant_evaluation_status_cd', name: 'engineering_consultant_evaluation_status_cd' },
                { data: 'approval_status_cd', name: 'approval_status_cd' },
                { data: 'awarded_engineering_creator_approval_cd', name: 'awarded_engineering_creator_approval_cd' },
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
        $('[data-kt-project-table-filter="search"]').on('keyup', function () {
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
            $('#project_type_cd').val(null).trigger('change'); // Reset and update UI
            table.draw(); // refresh table
        });
    });


</script>
