<script>
    var KTUsersEditUser = function () {
        // Shared variables
        const element = document.getElementById('kt_modal_update_details');
        const form = element.querySelector('#kt_modal_update_user_form');
        const user_id = element.querySelector('#edit_user_id')
        const modal = new bootstrap.Modal(element);

        // Init add schedule modal
        var initAddUser = () => {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'user_name': {
                            validators: {
                                notEmpty: {
                                    message: '@lang('admin.Full Name Filed is required')'
                                }
                            }
                        },
                        'user_email': {
                            validators: {
                                notEmpty: { message: '@lang('admin.Email address is required')' },
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: '@lang('admin.Invalid email address')',
                                }
                            }
                        },
                        'mobile_number': {
                            validators: {
                                notEmpty: { message: '@lang('admin.Mobile number  is required')' },
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Submit button handler
            const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
            submitButton.addEventListener('click', e => {
                e.preventDefault();

                // Validate form before submit
                if (validator) {
                    validator.validate().then(function (status) {

                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            setTimeout(function () {
                                // Remove loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                                const formData = new FormData(form); // Handles file uploads too
                                const user_Id = user_id.value; // Get role_id from the hidden input
                                const url = `/users/update/${user_Id}`; // Build the correct URL
                                // Show popup confirmation

                                    fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    })
                                    .then(async response => {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        const data = await response.json();

                                        if (response.ok) {
                                            Swal.fire({
                                                text: "@lang('admin.Form has been successfully submitted!')",
                                                icon: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-primary"
                                                }
                                            }).then(function (result) {
                                                if (result.isConfirmed) {
                                                    form.reset();
                                                    modal.hide();

                                                }
                                            });
                                        } else if (response.status === 422) {
                                            // Laravel validation errors
                                            let errorMessages = Object.values(data.errors).flat().join('<br>');
                                            Swal.fire({
                                                html: `<div class="text-start">${errorMessages}</div>`,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-danger"
                                                }
                                            });
                                        } else {
                                            Swal.fire({
                                                text: data.message || "@lang('admin.Something went wrong.')",
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-danger"
                                                }
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        Swal.fire({
                                            text: "@lang('admin.Unexpected error: ')" + error.message,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "@lang('admin.OK')",
                                            customClass: {
                                                confirmButton: "btn btn-danger"
                                            }
                                        });
                                    });

                                //form.submit(); // Submit form
                            }, 2000);
                        } else {
                            // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "@lang('admin.Sorry, looks like there are some errors detected, please try again.')",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('admin.OK')",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                }
            });

            // Cancel button handler
            const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
            cancelButton.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    text: "@lang('admin.Are you sure you would like to cancel?')",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "@lang('admin.Yes, cancel it!')",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function (result) {
                    if (result.value) {
                        form.reset(); // Reset form
                        modal.hide();
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

            // Close button handler
            const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
            closeButton.addEventListener('click', e => {
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
                        form.reset(); // Reset form
                        modal.hide();
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "@lang('admin.Your form has not been cancelled!.')",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('admin.OK')",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            }
                        });
                    }
                });
            });
        }

        return {
            // Public functions
            init: function () {
                initAddUser();
            }
        };
    }();
    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        KTUsersEditUser.init();
    });

</script>
