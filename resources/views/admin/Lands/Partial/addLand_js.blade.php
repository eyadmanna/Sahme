<script>
    $(document).ready(function () {
        // Initialize select2
        $('select[name="language"]').select2();

        // Handle change
        $('select[name="language"]').on('change', function () {
            var investorId = $(this).val();
            if (investorId) {
                $.ajax({
                    url: '{{ route("admin.getInvestorDetails") }}', // Use a named route
                    type: 'GET',
                    data: { id: investorId },
                    success: function (response) {
                        console.log(response)
                        $('#investor_details').html(response).fadeIn();
                    },
                    error: function () {
                        $('#investor_details').html('<div class="alert alert-danger">Error loading data.</div>').fadeIn();
                    }
                });
            } else {
                $('#investor_details').fadeOut().html('');
            }
        });
    });
</script>
