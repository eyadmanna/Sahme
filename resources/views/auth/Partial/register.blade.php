<script type="module">
    "use strict";

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('#kt_sign_up_form');
        const submitButton = document.querySelector('#kt_sign_up_submit');
        const passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

        const validatePassword = () => passwordMeter.getScore() > 50;

        const validator = FormValidation.formValidation(form, {
            fields: {
                name: {
                    validators: {
                        notEmpty: { message: '@lang('admin.Full Name Filed is required')' },
                    }
                },
                email: {
                    validators: {
                        notEmpty: { message: '@lang('admin.Email address is required')' },
                        regexp: {
                            regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                            message: '@lang('admin.Invalid email address')',
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: { message: '@lang('admin.The password is required')' },
                        callback: {
                            message: '@lang('admin.Please enter a valid password')',
                            callback: (input) => input.value.length > 0 ? validatePassword() : false
                        }
                    }
                },
                "password_confirmation": {
                    validators: {
                        notEmpty: { message: '@lang('admin.Password confirmation is required')' },
                        identical: {
                            compare: () => form.querySelector('[name="password"]').value,
                            message: '@lang('admin.Passwords do not match')'
                        }
                    }
                },
                toc: {
                    validators: {
                        notEmpty: { message: '@lang('admin.You must accept the terms and conditions')' }
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
                            text: "@lang('admin.Registration successful!')",
                            icon: "success",
                            confirmButtonText: "@lang('admin.OK')",
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
                            let errorMessages = '';

                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errorMessages += `${errors[key][0]}<br>`;
                                }
                            }

                            Swal.fire({
                                html: errorMessages,
                                icon: "error",
                                confirmButtonText: "@lang('admin.OK')",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        } else {
                            // General error
                            Swal.fire({
                                text: "@lang('admin.Sorry, an error occurred. Please try again.')",
                                icon: "error",
                                confirmButtonText: "@lang('admin.OK')",
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
                        text: "@lang('admin.Please fix the errors in the form.')",
                        icon: "error",
                        confirmButtonText: "@lang('admin.OK')",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    });
</script>
