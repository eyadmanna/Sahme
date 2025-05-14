<script>
    $(document).ready(function () {
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




        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
            url: "{{ route('lands.upload_legal_attachment', $land->id) }}",
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            init: function () {
                var dz = this;

                // تحميل المرفقات السابقة عند فتح الصفحة
                @foreach($land->attachments()->where('type', 'ownership_certification')->get() as $file)
                var mockFile = { name: "{{ basename($file->file_path) }}", size: 123456, serverId: "{{ $file->id }}" };
                dz.emit("addedfile", mockFile);
                dz.emit("thumbnail", mockFile, "{{ asset('storage/'.$file->file_path) }}");
                dz.emit("complete", mockFile);
                @endforeach

                // عند نجاح الرفع
                this.on("success", function (file, response) {
                    file.serverId = response.file_id;
                });

                // عند حذف الملف
                this.on("removedfile", function (file) {
                    if (file.serverId) {
                        $.ajax({
                            url: "{{ route('lands.delete_attachment') }}",
                            type: 'POST',
                            data: {
                                file_id: file.serverId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function () {
                                console.log("Deleted successfully");
                            },
                            error: function () {
                                console.log("Error deleting file");
                            }
                        });
                    }
                });
            }
        });
    });
</script>
<script>
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

    let map;
    let marker;

    function initMap() {
        const initialLat = parseFloat(document.getElementById('lat').value) || 31.5012;
        const initialLng = parseFloat(document.getElementById('long').value) || 34.4663;
        const initialLocation = { lat: initialLat, lng: initialLng };

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: initialLocation,
        });

        marker = new google.maps.Marker({
            position: initialLocation,
            map: map,
            draggable: true
        });

        // When marker is dragged update input fields
        marker.addListener('dragend', function (event) {
            document.getElementById('lat').value = event.latLng.lat().toFixed(6);
            document.getElementById('long').value = event.latLng.lng().toFixed(6);
        });
    }

    // When input fields change update the map
    document.getElementById('lat').addEventListener('input', updateMap);
    document.getElementById('long').addEventListener('input', updateMap);

    function updateMap() {
        const lat = parseFloat(document.getElementById('lat').value);
        const lng = parseFloat(document.getElementById('long').value);

        if (!isNaN(lat) && !isNaN(lng)) {
            const newPosition = { lat: lat, lng: lng };
            marker.setPosition(newPosition);
            map.setCenter(newPosition);
        }
    }</script>
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA&callback=initMap" async defer></script>


