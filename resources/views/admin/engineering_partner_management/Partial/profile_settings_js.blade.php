<script>
    $(document).ready(function () {

        // عند تحميل الصفحة نعين القيم إذا كانت موجودة
        let selectedProvince = '{{ $user->province_cd ?? '' }}';
        let selectedCity = '{{ $user->city_cd ?? '' }}';
        let selectedDistrict = '{{ $user->district_cd ?? '' }}';

        if (selectedProvince !== '') {
            $('#location_province').val(selectedProvince).trigger('change');

            // ننتظر تحميل المدن
            setTimeout(function () {
                $('#location_cities').val(selectedCity).trigger('change');
            }, 5000);

            // ننتظر تحميل المناطق
            setTimeout(function () {
                $('#location_areas').val(selectedDistrict).trigger('change');
            }, 7000);
        }
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


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('kt_account_profile_details_form');
        const saveButton = document.getElementById('add_form');
        const data_url = '{{ route('engineering_partners.update_settings',$user->id) }}';

        // إعداد التحقق
        const formValidation = FormValidation.formValidation(form, {
            fields: {
                'logo': {
                    validators: {
                        file: {
                            extension: 'jpeg,png,jpg',
                            type: 'image/jpeg,image/png',
                            message: '{{ __("engineering.allowed_file_types") }}' // تأكد تضيف هذا النص للغة
                        }
                    }
                },
                'company_name': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.company_name_required") }}'
                        }
                    }
                },
                'mobile': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.mobile_required") }}'
                        }
                    }
                },
                'province_cd': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.province_required") }}'
                        }
                    }
                },
                'city_cd': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.city_required") }}'
                        }
                    }
                },
                'district_cd': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.district_required") }}'
                        }
                    }
                },
                'address': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.address_required") }}'
                        }
                    }
                },
                'experience_years': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.experience_years_required") }}'
                        }
                    }
                },
                'commercial_registration_number': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.commercial_registration_required") }}'
                        }
                    }
                },
                'specializations': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.specializations_required") }}'
                        }
                    }
                },
                'tax_number': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.tax_number_required") }}'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: 'is-invalid',  // ✅ Border أحمر
                    eleValidClass: 'is-valid',       // ✅ Border أخضر
                    // ✅ لإظهار الأيقونات
                    formClass: 'fv-plugins-bootstrap5',
                    messageClass: 'fv-help-block',
                    invalidFormClass: 'fv-plugins-bootstrap5-invalid',
                    validFormClass: 'fv-plugins-bootstrap5-valid'
                }),

            }
        });
        // تفعيل Select2 وربطها بالفاليديشن
        ['province_cd', 'city_cd', 'district_cd'].forEach(function (field) {
            const $element = $('[name="' + field + '"]');

            $element.select2({
                placeholder: $element.data('placeholder'),
                width: '100%'
            });

            // ربط الـ select2 بالتغيير للفاليديشن
            $element.on('change', function () {
                formValidation.revalidateField(field);
            });
        });


        // حدث عند الضغط على زر الحفظ
        saveButton.addEventListener('click', function (e) {
            e.preventDefault();

            formValidation.validate().then(function (status) {
                if (status === 'Valid') {
                    const formData = new FormData(form);

                    saveButton.disabled = true;
                    saveButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("engineering.saving") }}`;

                    $.ajax({
                        url: data_url,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            saveButton.disabled = false;
                            saveButton.textContent = '{{ __("engineering.save_changes") }}';
                            if (data.success) {
                                toastr.success(data.message || '{{ __("engineering.profile_updated_successfully") }}');
                            } else {
                                toastr.error(data.message || '{{ __("engineering.error_occurred") }}');
                            }
                        },
                        error: function (xhr, status, error) {
                            saveButton.disabled = false;
                            saveButton.textContent = '{{ __("engineering.save_changes") }}';
                            toastr.error('{{ __("engineering.unexpected_error_occurred") }}');
                            console.error(error);
                        }
                    });
                }
                else {
                    // تمرير الصفحة لأول خطأ
                    const firstErrorElement = form.querySelector('.fv-plugins-bootstrap5-row-invalid');
                    if (firstErrorElement) {
                        firstErrorElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstErrorElement.focus();
                    }
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form_password = document.getElementById('kt_signin_change_password');
        const saveButton_password = document.getElementById('kt_password_submit');
        const data_url_password = '{{ route('engineering_partners.profile.update-password',$user->id) }}';

        const formValidation = FormValidation.formValidation(form_password, {
            fields: {
                'currentpassword': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.current_password_required") }}'
                        }
                    }
                },
                'newpassword': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.new_password_required") }}'
                        },
                        stringLength: {
                            min: 8,
                            message: '{{ __("engineering.password_min_length") }}'
                        }
                    }
                },
                'confirmpassword': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.confirm_password_required") }}'
                        },
                        identical: {
                            compare: function () {
                                return form_password.querySelector('[name="newpassword"]').value;
                            },
                            message: '{{ __("engineering.passwords_do_not_match") }}'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: 'is-invalid',
                    eleValidClass: 'is-valid'
                }),
            }
        });

        saveButton_password.addEventListener('click', function (e) {
            e.preventDefault();

            formValidation.validate().then(function (status) {
                if (status === 'Valid') {
                    const formData = new FormData(form_password);

                    saveButton_password.disabled = true;
                    saveButton_password.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("engineering.saving") }}`;

                    $.ajax({
                        url: data_url_password,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            saveButton_password.disabled = false;
                            saveButton_password.textContent = '{{ __("engineering.Update Password") }}';

                            // ✅ إزالة الأخطاء السابقة
                            form_password.querySelectorAll('.is-invalid').forEach(function (el) {
                                el.classList.remove('is-invalid');
                            });
                            form_password.querySelectorAll('.invalid-feedback').forEach(function (el) {
                                el.remove();
                            });

                            toastr.success(data.message || '{{ __("engineering.password_updated_successfully") }}');
                            form_password.reset();
                            formValidation.resetForm();
                        },

                        error: function (xhr) {
                            saveButton_password.disabled = false;
                            saveButton_password.textContent = '{{ __("engineering.Update Password") }}';

                            const errors = xhr.responseJSON?.errors || {};
                            if (xhr.status === 422 && Object.keys(errors).length > 0) {
                                Object.keys(errors).forEach(function (field) {
                                    let input = form_password.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid');
                                        let feedback = input.nextElementSibling;
                                        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                                            feedback = document.createElement('div');
                                            feedback.classList.add('invalid-feedback');
                                            input.parentNode.insertBefore(feedback, input.nextSibling);
                                        }
                                        feedback.textContent = errors[field][0];
                                    }
                                });

                                toastr.error(Object.values(errors)[0][0]);
                            } else if (xhr.responseJSON?.message) {
                                toastr.error(xhr.responseJSON.message);

                                const inputCurrent = form_password.querySelector('[name="currentpassword"]');
                                if (inputCurrent) {
                                    inputCurrent.classList.add('is-invalid');
                                    let feedback = inputCurrent.nextElementSibling;
                                    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                                        feedback = document.createElement('div');
                                        feedback.classList.add('invalid-feedback');
                                        inputCurrent.parentNode.insertBefore(feedback, inputCurrent.nextSibling);
                                    }
                                    feedback.textContent = xhr.responseJSON.message;
                                }
                            } else {
                                toastr.error('{{ __("engineering.unexpected_error_occurred") }}');
                            }
                        }
                    });
                }
            });
        });
    });
</script>


<script !src="">
    "use strict";

    var KTChangePassword = function () {
        var passwordForm;
        var passwordMainEl;
        var passwordEditEl;
        var passwordChange;
        var passwordCancel;

        var toggleChangePassword = function () {
            passwordMainEl.classList.toggle('d-none');
            passwordChange.classList.toggle('d-none');
            passwordEditEl.classList.toggle('d-none');
        }


        return {
            init: function () {
                passwordForm = document.getElementById('kt_signin_change_password');
                passwordMainEl = document.getElementById('kt_signin_password');
                passwordEditEl = document.getElementById('kt_signin_password_edit');
                passwordChange = document.getElementById('kt_signin_password_button');
                passwordCancel = document.getElementById('kt_password_cancel');

                if (!passwordForm || !passwordChange || !passwordCancel) return;

                passwordChange.querySelector('button').addEventListener('click', toggleChangePassword);
                passwordCancel.addEventListener('click', toggleChangePassword);

            }
        }
    }();

    KTUtil.onDOMContentLoaded(function () {
        KTChangePassword.init();
    });

</script>


