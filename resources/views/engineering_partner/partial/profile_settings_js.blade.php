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
        const data_url = '{{ route('engineering.profile.update') }}';

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
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
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

