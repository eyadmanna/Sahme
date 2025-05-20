<script type="module">
    "use strict";

    $(document).ready(function () {
        let table = $("#kt_table_users").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get_engineering_partners') }}",
                data: function (d) {
                    d.mobile_number = $('#mobile').val();
                    d.role = $('#role').val();
                }
            },
            columns: [
                { data: 'company_name', name: 'company_name' }, // 👈 This matches the column
                { data: 'mobile', name: 'mobile' },
                 { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                "url": "{{url('/')}}/assets/Arabic.json"
            },
            createdRow: function (row, data, dataIndex) {
                $('td', row).each(function (index) {
                    // استثنِ العمود الثاني (name) وأضف class لباقي الأعمدة
                    if (index !== 0) {
                        $(this).attr('class', 'text-center');
                    }
                });
            },
            drawCallback: function () {
                if (typeof KTMenu !== 'undefined') {
                    KTMenu.createInstances();
                }
            }
        });
        let searchTimeout;
        $('[data-kt-user-table-filter="search"]').on('keyup', function () {
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
            $('#role').val(null).trigger('change'); // Reset and update UI
                table.draw(); // refresh table
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


                                    // Enable button
                                    submitButton.disabled = false;
                                    const formData = new FormData(form); // Handles file uploads too

                                    // Show popup confirmation

                                    fetch('{{ route('users.store') }}', {
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
                                                        modal.hide(); // Hide the modal if needed
                                                        table.ajax.reload(); //  Reload the DataTable
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
                                                text: "@lang('admin.Unexpected error: ')",
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-danger"
                                                }
                                            });
                                        });
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
                                confirmButtonText: "@lang('OK')",
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

        $(document).on('click', '[data-kt-users-table-filter="delete_row"]', function (e) {
            e.preventDefault();


            const parent = $(this).closest('tr');
            const userName = parent.find('.user-name').text().trim();
            const userId = $(this).data('user-id');
            const userStatus = $(this).data('user-status');

            const confirmText = userStatus == 1
                ? "{{ __('admin.Are you sure you want to delete') }}"
                : "{{ __('admin.Are you sure you want to reactivate?') }}";
            Swal.fire({
                text: confirmText + ' ' + userName + '?',
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "@lang('admin.Yes, delete!')",
                cancelButtonText: "@lang('admin.No, cancel')",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('/users/delete/') }}/${userId}`,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function (response) {
                            Swal.fire({
                                text: userName + " @lang('admin.has been deleted.')",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('admin.OK')",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(() => {
                                $('#kt_table_users').DataTable().ajax.reload(null, false);
                            });
                        },
                        error: function (xhr) {
                            let message = "@lang('admin.Error deleting user. Please try again.')";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                text: message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('admin.OK')",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: userName + "@lang('admin.was not deleted.')",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "@lang('admin.OK')",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary"
                        }
                    });
                }
            });
        });

// On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTUsersAddUser.init();

        });
    });

</script>
<script type="module">
    "use strict";

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('#kt_sign_up_form');
        const submitButton = document.querySelector('#kt_sign_up_submit');
        const passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

        const validatePassword = () => passwordMeter.getScore() > 50;

        const validator = FormValidation.formValidation(form, {
            fields: {
                company_name: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Company Name is required')' },
                    }
                },
                province_cd: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Select province is required')' },
                    }
                },
                city_cd: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Select city is required')' },
                    }
                },
                district_cd: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Select district is required')' },
                    }
                },
                address: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Address is required')' },
                    }
                },
                experience_years: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Years of experience is required')' },
                    }
                },
                commercial_registration_number: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Commercial registration number is required')' },
                    }
                },
                specializations: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Specializations is required')' },
                    }
                },tax_number: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.tax number is required')' },
                    }
                },
                email: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Email address is required')' },
                        regexp: {
                            regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                            message: '@lang('engineering.Invalid email address')',
                        }
                    }
                },
                mobile: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Mobile number is required')' },
                        stringLength: {
                            max: 15,
                            message: '@lang('engineering.The mobile field must not be greater than 15 characters')',
                        }
                    }
                },
                company_profile: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Company profile is required')' },
                    }
                },
                commercial_registration: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Commercial registration is required')' },
                    }
                },
                liecence: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Licence is required')' },
                    }
                },
                tax_record: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Tax record is required')' },
                    }
                },
                previous_projects: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Previous projects is required')' },
                    }
                },
                password: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.The password is required')' },
                        callback: {
                            message: '@lang('engineering.Please enter a valid password')',
                            callback: (input) => input.value.length > 0 ? validatePassword() : false
                        }
                    }
                },
                "password_confirmation": {
                    validators: {
                        notEmpty: { message: '@lang('engineering.Password confirmation is required')' },
                        identical: {
                            compare: () => form.querySelector('[name="password"]').value,
                            message: '@lang('engineering.Passwords do not match')'
                        }
                    }
                },
                toc: {
                    validators: {
                        notEmpty: { message: '@lang('engineering.You must accept the terms and conditions')' }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        });

        form.querySelector('[name="password"]').addEventListener('input', () => {
            validator.updateFieldStatus('password', 'NotValidated');
        });

        submitButton.addEventListener('click', async (e) => {
            e.preventDefault();

            await validator.revalidateField('password');

            validator.validate().then(async (status) => {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    try {
                        const formData = new FormData(form);
                        const actionUrl = form.getAttribute('action');

                        const response = await axios.post(actionUrl, formData);

                        Swal.fire({
                            text: "@lang('engineering.Registration successful!')",
                            icon: "success",
                            confirmButtonText: "@lang('engineering.OK')",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            },
                        }).then(() => {
                            const redirectUrl = form.getAttribute('data-kt-redirect-url');
                            if (redirectUrl) {
                                window.location.href = redirectUrl;
                            } else {
                                form.reset();
                                passwordMeter.reset();
                            }
                        });

                    } catch (error) {
                        if (error.response && error.response.status === 422) {
                            // Laravel validation error
                            const errors = error.response.data.errors;
                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    const inputElement = form.querySelector(`[name="${key}"]`);
                                    const errorElement = inputElement.closest('.fv-row').querySelector('.fv-plugins-message-container');

                                    if (errorElement) {
                                        errorElement.innerHTML = errors[key][0];
                                    } else {
                                        const errorDiv = document.createElement('div');
                                        errorDiv.classList.add('fv-plugins-message-container');
                                        errorDiv.innerHTML = errors[key][0];
                                        inputElement.closest('.fv-row').appendChild(errorDiv);
                                    }
                                }
                            }
                        } else {
                            // General error
                            Swal.fire({
                                text: "@lang('engineering.Sorry, an error occurred. Please try again.')",
                                icon: "error",
                                confirmButtonText: "@lang('engineering.OK')",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    } finally {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    }

                } else {
                    Swal.fire({
                        text: "@lang('engineering.Please fix the errors in the form.')",
                        icon: "error",
                        confirmButtonText: "@lang('engineering.OK')",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).on("change", "select.location_province", function () {
        var province_id = $(this).val();
        var this_city = $("#location_cities");
        var this_area = $("#location_areas");
        var cities_block = document.querySelector("#cities_block");

        var blockUI = KTBlockUI.getInstance(cities_block);

        if (!blockUI) {
            blockUI = new KTBlockUI(cities_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });
        }

        if (province_id !== '') {
            blockUI.block();
            this_city.empty();
            this_area.empty();


            $.ajax({
                method: "POST",
                url: '{{route('get_children_by_parent')}}',
                dataType: 'json',
                data: {id: province_id, '_token': '{{csrf_token()}}'},
                success: function (data, textStatus, jqXHR) {
                    this_city.append(data.children);


                },
                complete:function (){
                    blockUI.release(); // Release blockUI when the request is successful
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    blockUI.release(); // Release blockUI when the request fails
                }
            });
        } else {
            blockUI.release(); // Release blockUI immediately if province_id is empty
        }
    });

    $(document).on("change", "select.location_city", function () {
        var city_id = $(this).val();
        var this_area = $("#location_areas");
        var areas_block = document.querySelector("#areas_block");

        var blockUI = KTBlockUI.getInstance(areas_block);

        if (!blockUI) {
            blockUI = new KTBlockUI(areas_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });
        }

        if (city_id !== '') {
            blockUI.block();
            this_area.empty();

            $.ajax({
                method: "POST",
                url: '{{route('get_children_by_parent')}}',
                dataType: 'json',
                data: {id: city_id, '_token': '{{csrf_token()}}'},
                success: function (data, textStatus, jqXHR) {
                    this_area.append(data.children);

                },
                complete:function (){
                    blockUI.release(); // Release blockUI when the request is successful
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    blockUI.release(); // Release blockUI when the request fails
                }
            });
        } else {
            blockUI.release(); // Release blockUI immediately if province_id is empty
        }
    });

</script>
