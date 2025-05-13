<script>
    "use strict";

    var KTSigninGeneral = function () {
        var form;
        var submitButton;
        var validator;

        var handleValidation = function () {
            validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'email': {
                            validators: {
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: '@lang("admin.The value is not a valid email address")',
                                },
                                notEmpty: {
                                    message: '@lang("admin.Email address is required")'
                                }
                            }
                        },
                        'password': {
                            validators: {
                                notEmpty: {
                                    message: '@lang("admin.The password is required")'
                                }
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
                }
            );

            form.querySelectorAll('input').forEach(function (input) {
                input.addEventListener('input', function () {
                    validator.validate().then(function (status) {
                        submitButton.disabled = (status !== 'Valid');
                    });
                });
            });

            submitButton.disabled = true;
        };

        var handleSubmitAjax = function () {
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        let formData = new FormData(form);

                        $.ajax({
                            url: $(form).attr('action'),
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                form.reset();

                                Swal.fire({
                                    text: response.message || "@lang('admin.You have successfully logged in!')",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "@lang('admin.OK')",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    },
                                    didOpen: () => {
                                        document.querySelector('.swal2-popup').dir = 'rtl';
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        // استخدم redirect من الريسونس مباشرة
                                        if (response.redirect) {
                                            window.location.href = response.redirect;
                                        } else {
                                            var fallbackUrl = form.getAttribute('data-kt-redirect-url');
                                            if (fallbackUrl) {
                                                window.location.href = fallbackUrl;
                                            }
                                        }
                                    }
                                });
                            },
                            error: function (xhr) {
                                if (xhr.status === 422) {
                                    let message = xhr.responseJSON.message || '';
                                    let errors = xhr.responseJSON.errors || {};
                                    let errorMessages = message ? message + '<br>' : '';

                                    $.each(errors, function (key, messages) {
                                        errorMessages += messages[0] + '<br>';
                                    });

                                    Swal.fire({
                                        html: errorMessages,
                                        icon: "error",
                                        confirmButtonText: "@lang('admin.OK')",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        text: "@lang('admin.Sorry, an error occurred. Please try again.')",
                                        icon: "error",
                                        confirmButtonText: "@lang('admin.OK')",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            },

                            complete: function () {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                            }
                        });
                    } else {
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
            });
        };

        var isValidUrl = function (url) {
            try {
                new URL(url);
                return true;
            } catch (e) {
                return false;
            }
        };

        return {
            init: function () {
                form = document.querySelector('#kt_sign_in_form');
                submitButton = document.querySelector('#kt_sign_in_submit');

                handleValidation();

                if (isValidUrl(form.getAttribute('action'))) {
                    handleSubmitAjax();
                }
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function () {
        KTSigninGeneral.init();
    });
</script>
