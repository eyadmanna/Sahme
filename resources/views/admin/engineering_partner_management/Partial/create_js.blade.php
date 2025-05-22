
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
        const form = document.getElementById('kt_account_form');
        const saveButton = document.getElementById('add_form');
        const data_url = '{{ route('engineering_partners.store') }}';

        // إعداد التحقق
        const formValidation = FormValidation.formValidation(form, {
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
                {{--address: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Address is required')' },--}}
                {{--    }--}}
                {{--},--}}
                {{--experience_years: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Years of experience is required')' },--}}
                {{--    }--}}
                {{--},--}}
                {{--commercial_registration_number: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Commercial registration number is required')' },--}}
                {{--    }--}}
                {{--},--}}
                {{--specializations: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Specializations is required')' },--}}
                {{--    }--}}
                {{--},tax_number: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.tax number is required')' },--}}
                {{--    }--}}
                {{--},--}}
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

                {{--'logo': {--}}
                {{--    validators: {--}}
                {{--        file: {--}}
                {{--            extension: 'jpeg,png,jpg',--}}
                {{--            type: 'image/jpeg,image/png',--}}
                {{--            message: '{{ __("engineering.allowed_file_types") }}' // تأكد تضيف هذا النص للغة--}}
                {{--        },--}}
                {{--        notEmpty: { message: '@lang('engineering.Logo is required')' },--}}

                {{--    }--}}
                {{--},--}}
                {{--company_profile: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Company profile is required')' },--}}
                {{--    }--}}
                {{--},--}}
                {{--commercial_registration: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Commercial registration is required')' },--}}
                {{--    }--}}
                {{--},--}}
                {{--liecence: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Licence is required')' },--}}
                {{--    }--}}
                {{--},--}}
                {{--tax_record: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Tax record is required')' },--}}
                {{--    }--}}
                {{--},--}}
                {{--previous_projects: {--}}
                {{--    validators: {--}}
                {{--        notEmpty: { message: '@lang('engineering.Previous projects is required')' },--}}
                {{--    }--}}
                {{--},--}}

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
                            saveButton.textContent = '{{ __("admin.Sign up") }}';
                            if (data.success) {
                                toastr.success(data.message || '{{ __("engineering.engineering_partner_added_successfully") }}');

                                // إعادة ضبط النموذج العادي
                                form.reset();

                                // الحقول التي تريد تنظيفها
                                const fieldsToReset = ['province_cd', 'city_cd', 'district_cd'];

                                fieldsToReset.forEach(function (field) {
                                    const $select = $('[name="' + field + '"]');

                                    // تفريغ Select2
                                    $select.val(null).trigger('change');

                                    // إزالة كلاس is-invalid من select وواجهة select2
                                    $select.removeClass('is-invalid');
                                    $select.siblings('.select2').find('.select2-selection').removeClass('is-invalid');

                                    // إزالة رسالة الخطأ الخاصة بالحقل إن وجدت
                                    $select.closest('.fv-row')
                                        .find('.fv-plugins-message-container')
                                        .empty();

                                    // إعادة ضبط التحقق من الحقل عبر FormValidation
                                    formValidation.resetField(field, true);
                                });
                                $('.fv-plugins-message-container').remove();
                                // إعادة تعيين كافة الحقول والتحققات
                                formValidation.resetForm(true);
                                window.location='{{route('engineering_partners.index')}}'
                            }



                            else {
                                toastr.error(data.message || '{{ __("engineering.error_occurred") }}');
                            }
                        },
                        error: function (xhr, status, error) {
                            saveButton.disabled = false;
                            saveButton.textContent = '{{ __("admin.Sign up") }}';
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




