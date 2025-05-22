<script>
    $(document).ready(function () {
        // Initialize select2
        $('select[name="investor_id"]').select2();

        // Handle change
        $('select[name="investor_id"]').on('change', function () {
            var investorId = $(this).val();
            if (investorId) {
                $.ajax({
                    url: '{{ route("admin.getInvestorDetails") }}', // Use a named route
                    type: 'GET',
                    data: { id: investorId },
                    success: function (response) {
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

        $('select[name="investor_id"]').trigger('change');

        $(document).on('click', '.openImagePreview', function () {
            let imageUrl = $(this).data('image');
            $('#previewImage').attr('src', imageUrl);
            $('#imagePreviewModal').modal('show');
        });

    });


</script>


