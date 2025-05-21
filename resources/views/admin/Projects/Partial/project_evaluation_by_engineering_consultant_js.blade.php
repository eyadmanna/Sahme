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
            var form = document.querySelector('#kt_engineering_consultant_evaluation_project');
            var form_notes = document.querySelector('#kt_modal_modify_engineering_consultant_evaluation_notes_form');
            const element = document.getElementById('kt_content_container_project');
            var initAddproject = function () {

                const submitButton = element.querySelector('[data-kt-project-evaluation-engineering-consultant-action="submit"]');
                submitButton.addEventListener('click', e => {
                    e.preventDefault();
                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                // Get the action value
                                const action = submitButton.value;

                                setTimeout(function () {

                                    const formData = new FormData(form);
                                    formData.append('action', action); // Ensure action is sent

                                    const project_Id = document.getElementById('project_id').value;
                                    const url = `{{url("/")}}/projects/engineering-consultant-evaluation/${project_Id}`; // Build the correct URL

                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;
                                    fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    })
                                        .then(async response => {
                                            let data = {};
                                            try {
                                                data = await response.json();
                                            } catch (e) {
                                                console.error('Invalid JSON response');
                                            }

                                            if (response.ok && data.status === 'success') {
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

                });

                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-project-evaluation-engineering-consultant-action="cancel"]');
                cancelButton.addEventListener('click', e => {
                    e.preventDefault();

                            window.location.href = "{{ route('projects.index') }}"; // Redirect to land.index route
                });
                const submitnoteButton = element.querySelector('[data-kt-project-evaluation-engineering-consultant-notes-action="submit"]');
                submitnoteButton.addEventListener('click', e => {
                    e.preventDefault();
                    submitnoteButton.setAttribute('data-kt-indicator', 'on');
                    submitnoteButton.disabled = true;

                    // Get the action value
                    const action = submitnoteButton.value;

                    setTimeout(function () {

                        const formData = new FormData(form_notes);
                        formData.append('action', action); // Ensure action is sent
                        const project_Id = document.getElementById('project_id').value;
                        const url = `{{url("/")}}/projects/engineering-consultant-evaluation/${project_Id}`; // Build the correct URL

                        submitnoteButton.removeAttribute('data-kt-indicator');
                        submitnoteButton.disabled = false;
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                            .then(async response => {
                                let data = {};
                                try {
                                    data = await response.json();
                                } catch (e) {
                                    console.error('Invalid JSON response');
                                }

                                if (response.ok && data.status === 'success') {
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
