<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Class definition
        var KTUsersAddRole = function () {
            // Shared variables
            const element = document.getElementById('kt_modal_add_role');
            const form = element.querySelector('#kt_modal_add_role_form');
            const modal = new bootstrap.Modal(element);

            // Init add schedule modal
            var initAddRole = () => {

                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                var validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'role_name': {
                                validators: {
                                    notEmpty: {
                                        message: '@lang('admin.Role name is required')'
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

                // Close button handler
                const closeButton = element.querySelector('[data-kt-roles-modal-action="close"]');
                closeButton.addEventListener('click', e => {
                    e.preventDefault();

                    Swal.fire({
                        text: "@lang('admin.Are you sure you would like to close?')",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "@lang('admin.Yes, close it!')",
                        cancelButtonText: "@lang('admin.No, return')",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            modal.hide(); // Hide modal
                        }
                    });
                });

                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-roles-modal-action="cancel"]');
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
                            form.reset(); // Reset form
                            modal.hide(); // Hide modal
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "@lang('admin.Your form has not been cancelled!.')",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('admin.Ok')",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                        }
                    });
                });

                // Submit button handler
                const submitButton = element.querySelector('[data-kt-roles-modal-action="submit"]');
                submitButton.addEventListener('click', function (e) {
                    // Prevent default button action
                    e.preventDefault();

                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function (status) {
                            console.log('validated!');

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

                                    fetch('{{ route('roles.store') }}', {
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
                                                        window.location.href = "{{ route('roles.index') }}";
                                                    }
                                                });
                                            } else if (response.status === 422) {
                                                // Laravel validation errors
                                                let errorMessages = Object.values(data.errors).flat().join('<br>');
                                                Swal.fire({
                                                    html: `<div class="text-center">${errorMessages}</div>`,
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


            }

            // Select all handler
            const handleSelectAll = () =>{
                // Define variables
                const selectAll = form.querySelector('#kt_roles_select_all');
                const allCheckboxes = form.querySelectorAll('[type="checkbox"]');

                // Handle check state
                selectAll.addEventListener('change', e => {

                    // Apply check state to all checkboxes
                    allCheckboxes.forEach(c => {
                        c.checked = e.target.checked;
                    });
                });
            }

            return {
                // Public functions
                init: function () {
                    initAddRole();
                    handleSelectAll();
                }
            };
        }();
        var KTUsersUpdatePermissions = function () {
            // Shared variables
            const element = document.getElementById('kt_modal_update_role');
            const form = element.querySelector('#kt_modal_update_role_form');
            const role_id = element.querySelector('#edit_role_id')
            const modal = new bootstrap.Modal(element);

            // Init add schedule modal
            var initUpdatePermissions = () => {

                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                var validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'role_name': {
                                validators: {
                                    notEmpty: {
                                        message: '@lang('admin.Role name is required')'
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

                // Close button handler
                const closeButton = element.querySelector('[data-kt-roles-modal-action="close"]');
                closeButton.addEventListener('click', e => {
                    e.preventDefault();

                    Swal.fire({
                        text: "@lang('admin.Are you sure you would like to close?')",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "@lang('admin.Yes, close it!')",
                        cancelButtonText: "@lang('admin.No, return')",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            modal.hide(); // Hide modal
                        }
                    });
                });

                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-roles-modal-action="cancel"]');
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
                            form.reset(); // Reset form
                            modal.hide(); // Hide modal
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

                // Submit button handler
                const submitButton = element.querySelector('[data-kt-roles-modal-action="submit"]');
                submitButton.addEventListener('click', function (e) {
                    // Prevent default button action
                    e.preventDefault();

                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function (status) {
                            console.log('validated!');

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
                                    const roleId = role_id.value; // Get role_id from the hidden input
                                    const url = `/update-roles/${roleId}`; // Build the correct URL

                                    fetch(url, {
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
                                                        confirmButton: "btn btn-primary",
                                                    }
                                                }).then(function (result) {
                                                    if (result.isConfirmed) {
                                                        form.reset();
                                                        window.location.href = "{{ route('roles.index') }}";
                                                    }
                                                });
                                            } else if (response.status === 422) {
                                                // Laravel validation errors
                                                let errorMessages = Object.values(data.errors).flat().join('<br>');
                                                Swal.fire({
                                                    html: `<div class="text-center">${errorMessages}</div>`,
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
            }

            // Select all handler
            const handleSelectAll = () => {
                // Define variables
                const selectAll = form.querySelector('#kt_roles_select_all');
                const allCheckboxes = form.querySelectorAll('[type="checkbox"]');

                // Handle check state
                selectAll.addEventListener('change', e => {

                    // Apply check state to all checkboxes
                    allCheckboxes.forEach(c => {
                        c.checked = e.target.checked;
                    });
                });
            }

            return {
                // Public functions
                init: function () {
                    initUpdatePermissions();
                    handleSelectAll();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTUsersAddRole.init();
            KTUsersUpdatePermissions.init();
        });
        document.querySelectorAll('.check-all-group').forEach(function (checkAllBox) {
            checkAllBox.addEventListener('change', function () {
                const group = this.dataset.group;
                const groupCheckboxes = document.querySelectorAll('.group-' + group);
                groupCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        });

        const td = document.getElementById('select-all-td');
        const selectAllCheckbox = document.getElementById('kt_roles_select_all');

        td.addEventListener('click', function (e) {
            // Avoid toggling twice if the actual checkbox was clicked
            if (e.target.tagName.toLowerCase() !== 'input') {
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
            }

            const isChecked = selectAllCheckbox.checked;

            // Check/uncheck all permission checkboxes
            document.querySelectorAll('input.permission-checkbox').forEach(cb => {
                cb.checked = isChecked;
            });
        });

        $(document).on('click', '.edit-role-btn', function () {
            let roleId = $(this).data('role-id');

            $.ajax({
                url: `/edit-roles/${roleId}`,
                method: 'GET',
                success: function (response) {
                    // Fill in the role name
                    $('input[name="role_name"]').val(response.name);
                    $('#edit_role_id').val(response.id);

                    // Uncheck all permissions first
                    $('input.permission-checkbox').prop('checked', false);

                    // Check permissions that are assigned
                    if (response.permissions) {
                        response.permissions.forEach(function (perm) {
                            $('input.permission-checkbox[value="' + perm.name + '"]').prop('checked', true);
                        });
                    }
                },
                error: function () {
                    alert('Failed to fetch role data.');
                }
            });
        });



    });

</script>
