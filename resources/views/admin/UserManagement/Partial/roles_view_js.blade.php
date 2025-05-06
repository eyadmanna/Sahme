<script>
    $(document).ready(function () {
        let table = $("#kt_roles_view_table").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/view-roles/'.$role->id) }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            searching: false,
            order: [[0, 'desc']],
            createdRow: function (row, data, dataIndex) {
                // Add class to the second cell (name column)
                $('td', row).eq(1).addClass('d-flex align-items-center');
            },
            drawCallback: function () {
                // 🔁 Re-initialize dropdown menu after each table draw
                if (typeof KTMenu !== 'undefined') {
                    KTMenu.createInstances(); // Metronic's JS function
                }
            }
        });

    });
</script>
