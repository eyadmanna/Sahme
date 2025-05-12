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
                url: '{{url("/")}}/lookups/get_children_by_parent',
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
                url: '{{url("/")}}/lookups/get_children_by_parent',
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


