<script type="module">
    "use strict";

    $(document).ready(function () {
        let table = $("#kt_table_users").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.getUsers') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'role', name: 'role', defaultContent: '-' },
                { data: 'last_login_at', name: 'last_login_at', defaultContent: '-' },
                { data: 'two_step', name: 'two_step', defaultContent: '-' },
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

// Class definition
        var KTUsersAddUser = function () {
            // Shared variables
            const element = document.getElementById('kt_modal_add_user');
            const form = element.querySelector('#kt_modal_add_user_form');
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

                                    // Show popup confirmation

                                    fetch('{{ route('users.store') }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                                                    text: data.message || "Something went wrong.",
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
                                                text: "Unexpected error: " + error.message,
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
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
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
                        text: "Are you sure you would like to cancel?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, cancel it!",
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
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
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
            KTUsersAddUser.init();
        });
    });

</script>
