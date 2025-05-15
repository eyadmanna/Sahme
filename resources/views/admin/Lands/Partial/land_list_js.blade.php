<script>
    $(document).ready(function () {
        let table = $("#kt_table_lands").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('lands.getLands') }}",
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
    });


</script>
