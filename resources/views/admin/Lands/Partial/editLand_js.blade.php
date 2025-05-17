<script>
    $(document).ready(function () {
        $(document).on("change", "select.location_province", function () {
            var province_id = $(this).val();
            var this_city = $("#location_cities");
            var this_area = $("#location_areas");
            var cities_block = document.querySelector("#cities_block");

            if (!cities_block) {
                console.error("#cities_block not found");
                return;
            }

            // استخدم getInstance أو أنشئ جديد عند الحاجة فقط
            var blockUI = KTBlockUI.getInstance(cities_block) ?? new KTBlockUI(cities_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });

            if (province_id !== '') {
                blockUI.block();
                this_city.empty();
                this_area.empty();

                $.ajax({
                    method: "POST",
                    url: '{{url("/")}}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: province_id, '_token': '{{csrf_token()}}' },
                    success: function (data) {
                        this_city.append(data.children);
                    },
                    complete: function () {
                        blockUI.release();
                    },
                    error: function () {
                        blockUI.release();
                    }
                });
            } else {
                blockUI.release();
            }
        });
        $(document).on("change", "select.location_city", function () {
            var city_id = $(this).val();
            var this_area = $("#location_areas");
            var areas_block = document.querySelector("#areas_block");

            if (!areas_block) {
                console.error("#areas_block not found");
                return;
            }

            var blockUI = KTBlockUI.getInstance(areas_block) ?? new KTBlockUI(areas_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });

            if (city_id !== '') {
                blockUI.block();
                this_area.empty();

                $.ajax({
                    method: "POST",
                    url: '{{url("/")}}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: city_id, '_token': '{{csrf_token()}}' },
                    success: function (data) {
                        this_area.append(data.children);
                    },
                    complete: function () {
                        blockUI.release();
                    },
                    error: function () {
                        blockUI.release();
                    }
                });
            } else {
                blockUI.release();
            }
        });

        // Initialize select2
        $('select[name="investor_id"]').select2();

        // Handle change
        $('select[name="investor_id"]').on('change', function () {
            var investorId = $(this).val();
            if (investorId) {
                $.ajax({
                    url: '{{ route("admin.getInvestorDetails") }}', // Use a named route
                    type: 'GET',
                    data: { id: investorId },
                    success: function (response) {
                        console.log(response)
                        $('#investor_details').html(response).fadeIn();
                    },
                    error: function () {
                        $('#investor_details').html('<div class="alert alert-danger">Error loading data.</div>').fadeIn();
                    }
                });
            } else {
                $('#investor_details').fadeOut().html('');
            }
        });

        $('select[name="investor_id"]').trigger('change');


        var KTLandsEditland = function () {
            var form = document.querySelector('#kt_add_land');
            const element = document.getElementById('kt_content_container_land');
            var validator = null;

            var initAddland = function () {
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            investor_id: { validators: { notEmpty: { message: '{{ __("admin.Full Name Filed is required") }}' } } },
                            land_description: { validators: { notEmpty: { message: '{{ __("admin.Description land filed is required") }}' } } },
                            province_cd: { validators: { notEmpty: { message: '{{ __("admin.Province Filed is required") }}' } } },
                            city_cd: { validators: { notEmpty: { message: '{{ __("admin.City Filed is required") }}' } } },
                            address: { validators: { notEmpty: { message: '{{ __("admin.Address Filed is required") }}' } } },
                            area: { validators: { notEmpty: { message: '{{ __("admin.Land area is required") }}' } } },
                            ownership_type_cd: { validators: { notEmpty: { message: '{{ __("admin.Ownership Type area is required") }}' } } },
                            price: {
                                validators: {
                                    notEmpty: { message: '{{ __("admin.Asking price is required") }}' },
                                    numeric: { message: '{{ __("admin.Price must be numeric") }}' }
                                }
                            },
                            lat: { validators: { notEmpty: { message: '{{ __("admin.Latitude is required") }}' } } },
                            long: { validators: { notEmpty: { message: '{{ __("admin.Longitude is required") }}' } } }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap5: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.col-md-3, .col-md-4, .col-md-8, .col-md-9',
                                eleInvalidClass: 'is-invalid',
                                eleValidClass: 'is-valid'
                            }),
                            submitButton: new FormValidation.plugins.SubmitButton(),
                            // Removed DefaultSubmit
                        }
                    }
                );

                validator.on('core.form.invalid', function () {
                    var invalidElements = form.querySelectorAll('.is-invalid');
                    if (invalidElements.length > 0) {
                        invalidElements[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                        invalidElements[0].focus();
                    }
                });

                const submitButton = element.querySelector('[data-kt-land-action="submit"]');
                submitButton.addEventListener('click', e => {
                    e.preventDefault();

                    if (validator) {
                        validator.validate().then(function (status) {
                            if (status == 'Valid') {
                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                setTimeout(function () {
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;

                                    const formData = new FormData(form);
                                    const land_Id = document.getElementById('land_id').value;
                                    const url = `{{url("/")}}/lands/update-land/${land_Id}`; // Build the correct URL

                                    fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    })
                                        .then(async response => {
                                            const data = await response.json();

                                            if (response.ok) {
                                                Swal.fire({
                                                    text: "@lang('admin.Form has been successfully submitted!')",
                                                    icon: "success",
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: { confirmButton: "btn btn-primary" }
                                                }).then(() => {
                                                    form.reset();
                                                    window.location.href = data.redirect; // Safe redirect from JS
                                                });
                                            } else if (response.status === 422) {
                                                let errorMessages = Object.values(data.errors).flat().join('<br>');
                                                Swal.fire({
                                                    html: `<div class="text-start">${errorMessages}</div>`,
                                                    icon: "error",
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: { confirmButton: "btn btn-danger" }
                                                });
                                            } else {
                                                Swal.fire({
                                                    text: data.message || "@lang('admin.Something went wrong.')",
                                                    icon: "error",
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: { confirmButton: "btn btn-danger" }
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            Swal.fire({
                                                text: "@lang('admin.Unexpected error: ')",
                                                icon: "error",
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: { confirmButton: "btn btn-danger" }
                                            });
                                        });
                                }, 1000);
                            } else {
                                Swal.fire({
                                    text: "@lang('admin.Sorry, looks like there are some errors detected, please try again.')",
                                    icon: "error",
                                    confirmButtonText: "@lang('admin.OK')",
                                    customClass: { confirmButton: "btn btn-primary" }
                                });
                            }
                        });
                    }
                });

                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-lands-action="cancel"]');
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
                            window.location.href = "{{ route('lands.index') }}"; // Redirect to land.index route

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
                init: function () {
                    initAddland();
                }
            };
        }();

// On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTLandsEditland.init();
            if (typeof $.fn.repeater !== 'function') {
                console.error('Repeater plugin not initialized!');
                return;
            }

            $('#kt_docs_repeater_basic').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        });

        $(document).on('click', '.delete-attachment-btn', function() {
            let id = $(this).data('id');
            let $button = $(this); // <<< هنا نخزن الزر في متغير

            Swal.fire({
                text: "@lang('admin.Are you sure you want to delete the item?')",
                icon: "warning",
                confirmButtonText: "@lang('admin.Yes')",
                customClass: { confirmButton: "btn btn-primary" }
            }).then(() => {
                $.ajax({
                    url: `/attachments/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            text: "@lang('admin.The item was deleted successfully')",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('OK')",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            }
                        });
                        $button.closest('li').remove();
                    }
                });
            });
        });

    });
</script>


