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

        $('select[name="investor_id"]').trigger('change');

        var KTValuationApprovalSubmitLegal  = function () {
            var form = document.querySelector('#kt_approval_valuation_land');
            const element = document.getElementById('kt_content_container_land');
            // تعريف العناصر المهمة
            var modal;
            var modify_price_form;
            var submit_button;
            var initValuationApprovalSubmitLegal = function () {

                const submitButtons = element.querySelectorAll('[data-kt-valuation-approval-action="submit"]');
                submitButtons.forEach(submitButton => {
                    submitButton.addEventListener('click', e => {
                        e.preventDefault();

                        // Get the action value
                        const action = submitButton.value;

                        // Show confirmation before sending
                        Swal.fire({
                            title: action === 'approved' ? '@lang("admin.Are you sure you want to approve?")' : '@lang("admin.Are you sure you want to reject?")',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '@lang("admin.Yes")',
                            cancelButtonText: '@lang("admin.No, return")',
                            customClass: {
                                confirmButton: 'btn btn-danger',
                                cancelButton: 'btn btn-secondary'
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                const formData = new FormData(form);
                                formData.append('action', action); // Ensure action is sent

                                const land_Id = document.getElementById('land_id').value;
                                const url = `{{url("/")}}/lands/approval-valuation-ownership/${land_Id}`; // Build the correct URL

                                fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: formData
                                })
                                    .then(async response => {
                                        let data = {};
                                        try {
                                            data = await response.json();
                                        } catch (e) {
                                            console.error('Invalid JSON response');
                                        }
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        if (response.ok) {
                                            Swal.fire({
                                                text: "@lang('admin.Form has been successfully submitted!')",
                                                icon: "success",
                                                confirmButtonText: "@lang('admin.OK')"
                                            }).then(() => {
                                                form.reset();
                                                window.location.href = data.redirect;
                                            });
                                        } else if (response.status === 422) {
                                            let errorMessages = Object.values(data.errors).flat().join('<br>');
                                            Swal.fire({
                                                html: `<div class="text-start">${errorMessages}</div>`,
                                                icon: "error",
                                                confirmButtonText: "@lang('admin.OK')"
                                            });
                                        } else {
                                            Swal.fire({
                                                text: data.message || "@lang('admin.Something went wrong.')",
                                                icon: "error",
                                                confirmButtonText: "@lang('admin.OK')"
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;
                                        Swal.fire({
                                            text: "@lang('admin.Unexpected error.')",
                                            icon: "error",
                                            confirmButtonText: "@lang('admin.OK')"
                                        });
                                    });
                            }
                        });
                    });
                });
                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-valuation-approval-action="cancel"]');
                cancelButton.addEventListener('click', e => {
                    e.preventDefault();

                    window.location.href = "{{ route('lands.index') }}"; // Redirect to land.index route

                });
            }

            var initValuationModifyPriceSubmitLegal = () => {
                var modal = document.querySelector("#kt_modal_modify_price");
                var modify_price_form = modal.querySelector("#kt_modal_modify_price_form");
                var submit_button = modal.querySelector('[data-kt-valuation-modify-price-action="submit"]');
                var validator = null;

                if (!modify_price_form || !submit_button) {
                    console.error("النموذج أو الزر غير موجود داخل المودال");
                    return;
                }

                // تفعيل التحقق من الحقول باستخدام FormValidation
                validator = FormValidation.formValidation(
                    modify_price_form,
                    {
                        fields: {
                            valuation_price: {
                                validators: {
                                    notEmpty: {
                                        message: '{{ __("admin.This field is required") }}'
                                    },
                                    numeric: {
                                        message: '{{ __("admin.Price must be numeric") }}'
                                    }
                                }
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap5: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: 'is-invalid',
                                eleValidClass: 'is-valid'
                            })
                        }
                    }
                );

                submit_button.addEventListener("click", function (e) {
                    e.preventDefault();

                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            submit_button.setAttribute("data-kt-indicator", "on");
                            submit_button.disabled = true;

                            const modify_action = submit_button.value;
                            const formData = new FormData(modify_price_form);
                            formData.append('action', modify_action);

                            const land_Id = document.getElementById('land_id').value;
                            const url = `{{ url('/') }}/lands/approval-valuation-ownership/${land_Id}`;

                            fetch(url, {
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData,
                            })
                                .then((response) => response.json())
                                .then((data) => {
                                    submit_button.removeAttribute("data-kt-indicator");
                                    submit_button.disabled = false;

                                    if (data.status == 'success') {
                                        const bootstrapModal = bootstrap.Modal.getInstance(modal);
                                        bootstrapModal.hide();

                                        Swal.fire({
                                            text: data.message,
                                            icon: "success",
                                            confirmButtonText: "موافق",
                                            customClass: {
                                                confirmButton: "btn btn-primary",
                                            },
                                        }).then(() => {
                                            window.location.href = data.redirect;
                                        });
                                    } else {
                                        Swal.fire({
                                            text: data.message || "حدث خطأ ما!",
                                            icon: "error",
                                            confirmButtonText: "موافق",
                                            customClass: {
                                                confirmButton: "btn btn-danger",
                                            },
                                        });
                                    }
                                })
                                .catch((error) => {
                                    console.error("خطأ في الاتصال:", error);
                                    submit_button.removeAttribute("data-kt-indicator");
                                    submit_button.disabled = false;

                                    Swal.fire({
                                        text: "حدث خطأ في الاتصال بالخادم.",
                                        icon: "error",
                                        confirmButtonText: "موافق",
                                        customClass: {
                                            confirmButton: "btn btn-danger",
                                        },
                                    });
                                });
                        } else {
                            Swal.fire({
                                text: "يرجى التأكد من إدخال البيانات بشكل صحيح.",
                                icon: "error",
                                confirmButtonText: "موافق",
                                customClass: {
                                    confirmButton: "btn btn-danger",
                                },
                            });
                        }
                    });
                });

                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-valuation-modify-price-action="cancel"]');
                cancelButton.addEventListener('click', e => {
                    e.preventDefault();

                    Swal.fire({
                        text: "@lang('admin.Are you sure you would like to cancel?')",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "@lang('admin.Yes, cancel it!')",
                        cancelButtonText: "@lang('admin.No, return')",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            var e = document.querySelector("#kt_modal_modify_price");
                            const emodal = bootstrap.Modal.getInstance(e); // ✅ استخدم getInstance بدلًا من new
                            if (emodal) {
                                emodal.hide();
                            }
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "@lang('admin.Your form has not been cancelled!.')",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('OK')",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                        }
                    });
                });
            };
                return {
                init: function () {
                    initValuationApprovalSubmitLegal();
                    initValuationModifyPriceSubmitLegal();
                }
            };
        }();
        KTUtil.onDOMContentLoaded(function () {
            KTValuationApprovalSubmitLegal.init();
        });



    });
</script>

