<script>
    function openInNewTab(button) {
        const url = button.getAttribute('data-url');
        if (url) {
            window.open(url, '_blank');
        }
    }
</script>
<script>
    $(document).on('click', '#accreditation', function () {

        Swal.fire({
            title: '{{ __("engineering.confirm_title") }}',
            text: '{{ __("engineering.confirm_text") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("engineering.confirm_button") }}',
            cancelButtonText: '{{ __("engineering.cancel_button") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('engineering_partners.accredit', $user->id) }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('{{ __("engineering.success_title") }}', '{{ __("engineering.success_text") }}', 'success');

                            $('#accreditation').fadeOut();
                            let badge_status=`
                            <i class="ki-duotone ki-verify fs-2hx text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>`;
                            $('#badge_status').html(badge_status);
                        } else {
                            Swal.fire('{{ __("engineering.error_title") }}', response.message ?? '{{ __("engineering.error_text") }}', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('{{ __("engineering.error_title") }}', '{{ __("engineering.error_text") }}', 'error');
                    }
                });
            }
        });

    });
</script>
<script>
    $(document).on('click', '#rejection', function () {
        let rejectionReason = '';
        Swal.fire({
            title: '{{ __("engineering.confirm_title") }}',
            text: '{{ __("engineering.reject_confirm_text") }}',
            icon: 'warning',
            input: 'textarea',
            inputLabel: '{{ __("engineering.rejection_reason_label") }}',
            inputPlaceholder: '{{ __("engineering.rejection_reason_placeholder") }}',
            inputAttributes: {
                'aria-label': 'Rejection reason'
            },
            showCancelButton: true,
            confirmButtonText: '{{ __("engineering.reject_button") }}',
            cancelButtonText: '{{ __("engineering.cancel_button") }}',
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('{{ __("engineering.rejection_reason_required") }}');
                }
                 rejectionReason = reason ?? '';
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('engineering_partners.reject', $user->id) }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        reason: result.value
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('{{ __("engineering.success_title") }}', response.message, 'success');
                            let rejectionHtml = `
                                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6">
                                    <i class="ki-duotone ki-information fs-2tx text-danger me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <div class="fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">@lang('engineering.We need your attention!')</h4>
                                            <div class="fs-6 text-gray-700 mb-2">
                                                @lang('engineering.Your request has been rejected. Please check the reason below.')
                                            </div>
                                            <div class="fs-6 text-danger">
                                                <strong>@lang('engineering.Rejection Reason'):</strong> ${rejectionReason}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;

                            document.getElementById('rejected_div').innerHTML = rejectionHtml;
                            let badge_status=`<i class="ki-duotone ki-shield-cross fs-2hx text-danger" >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>`;
                            $('#badge_status').html(badge_status);
                            $('#accreditation').remove();
                            $('#rejection').remove();
                            $('#re_accreditation').removeClass('d-none');
                        } else {
                            Swal.fire('{{ __("engineering.error_title") }}', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('{{ __("engineering.error_title") }}', '{{ __("engineering.error_text") }}', 'error');
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).on('click', '#re_accreditation', function () {

        Swal.fire({
            title: '{{ __("engineering.confirm_title") }}',
            text: '{{ __("engineering.confirm_text") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("engineering.confirm_button") }}',
            cancelButtonText: '{{ __("engineering.cancel_button") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('engineering_partners.accredit', $user->id) }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('{{ __("engineering.success_title") }}', '{{ __("engineering.success_text") }}', 'success');
                            let badge_status=`
                            <i class="ki-duotone ki-verify fs-2hx text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>`;
                            $('#badge_status').html(badge_status);
                            $('.notice').remove();
                            $('#re_accreditation').remove();
                        } else {
                            Swal.fire('{{ __("engineering.error_title") }}', response.message ?? '{{ __("engineering.error_text") }}', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('{{ __("engineering.error_title") }}', '{{ __("engineering.error_text") }}', 'error');
                    }
                });
            }
        });

    });
</script>

