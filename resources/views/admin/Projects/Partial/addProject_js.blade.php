<script>
    let myMap;
    let myMarker;

    // Global function for Google Maps callback (called by the script tag)
    function initMap() {
        // Placeholder - actual map initialization will happen after AJAX
        console.log('Google Maps API loaded');
    }

    $(document).ready(function () {
        // Initialize select2
        $('select[name="land_id"]').select2();

        // On change of land selection
        $('select[name="land_id"]').on('change', function () {
            const landId = $(this).val();
            const selectedOption = $(this).find('option:selected');
            const investorId = selectedOption.data('investor_id');
            const lat = parseFloat(selectedOption.data('lat'));
            const lng = parseFloat(selectedOption.data('long'));

            // Load Land Details
            if (landId) {
                $.ajax({
                    url: '{{ route("land.getLandDetails") }}',
                    type: 'GET',
                    data: { id: landId },
                    success: function (response) {
                        $('#land_details').html(response).fadeIn();

                        // Show map if coordinates are available
                        if (!isNaN(lat) && !isNaN(lng)) {
                            $('#map_card').fadeIn();

                            const location = { lat: lat, lng: lng };

                            // Initialize or update map
                            if (!myMap) {
                                myMap = new google.maps.Map(document.getElementById("map"), {
                                    zoom: 13,
                                    center: location,
                                });

                                myMarker = new google.maps.Marker({
                                    position: location,
                                    map: myMap,
                                    draggable: false,
                                });

                                myMarker.addListener('dragend', function (event) {
                                    $('#lat').val(event.latLng.lat().toFixed(6));
                                    $('#long').val(event.latLng.lng().toFixed(6));
                                });
                            } else {
                                myMap.setCenter(location);
                                myMarker.setPosition(location);
                            }

                            // Set initial coordinates if needed
                            $('#lat').val(lat.toFixed(6));
                            $('#long').val(lng.toFixed(6));
                        } else {
                            $('#map_card').hide();
                        }
                    },
                    error: function () {
                        const errorMessage = "{{ __('admin.Error loading data.') }}";
                        $('#land_details').html('<div class="alert alert-danger">' + errorMessage + '</div>').fadeIn();
                    }
                });
            } else {
                $('#land_details').fadeOut().html('');
                $('#map_card').fadeOut();
            }

            // Load Investor Details
            if (investorId) {
                $.ajax({
                    url: '{{ route("admin.getInvestorDetails") }}',
                    type: 'GET',
                    data: { id: investorId },
                    success: function (response) {
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

        // Trigger change on page load
        $('select[name="land_id"]').trigger('change');

        var KTProjectsAddproject = function () {
            var form = document.querySelector('#kt_add_project');
            const element = document.getElementById('kt_content_container_project');
            var validator = null;
            var initAddproject = function () {

                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            title: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            project_type_cd: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            area: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            project_cost: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },

                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap5: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
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

                const submitButton = element.querySelector('[data-kt-project-action="submit"]');
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
                                    const url = `{{ route('projects.store') }}`;

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
                const cancelButton = element.querySelector('[data-kt-project-action="cancel"]');
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
                    initAddproject();
                }
            };
        }();

// On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTProjectsAddproject.init();
        });
    });
</script>


<!-- Google Maps API -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA&callback=initMap">
</script>
