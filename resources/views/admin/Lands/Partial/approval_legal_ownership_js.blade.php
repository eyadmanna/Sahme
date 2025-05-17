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

        var KTLandsSubmitLegal  = function () {
            var form = document.querySelector('#kt_approval_legal_land');
            const element = document.getElementById('kt_content_container_land');
            const land_id = element.querySelector('#land_id')

            var initAddlandSubmitLegal = function () {

                const submitButtons = element.querySelectorAll('[data-kt-lands-legal-action="submit"]');
                submitButtons.forEach(submitButton => {
                    submitButton.addEventListener('click', e => {
                        e.preventDefault();

                        // Get the action value
                        const action = submitButton.value;

                        // Show confirmation before sending
                        Swal.fire({
                            title: action === 'approved' ? '@lang("admin.Are you sure you want to approve?")' : '@lang("admin.Are you sure you want to reject?")',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: '@lang("admin.Yes")',
                            cancelButtonText: '@lang("admin.No, return")',
                            customClass: {
                                confirmButton: 'btn btn-danger',
                                cancelButton: 'btn btn-secondary'
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                const formData = new FormData(form);
                                formData.append('action', action); // Ensure action is sent

                                const land_Id = document.getElementById('land_id').value;
                                const url = `{{url("/")}}/lands/approval-legal-ownership/${land_Id}`; // Build the correct URL

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
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        if (response.ok) {
                                            Swal.fire({
                                                text: "@lang('admin.Form has been successfully submitted!')",
                                                icon: "success",
                                                confirmButtonText: "@lang('admin.OK')"
                                            }).then(() => {
                                                form.reset();
                                                window.location.href = data.redirect;
                                            });
                                        } else if (response.status === 422) {
                                            let errorMessages = Object.values(data.errors).flat().join('<br>');
                                            Swal.fire({
                                                html: `<div class="text-start">${errorMessages}</div>`,
                                                icon: "error",
                                                confirmButtonText: "@lang('admin.OK')"
                                            });
                                        } else {
                                            Swal.fire({
                                                text: data.message || "@lang('admin.Something went wrong.')",
                                                icon: "error",
                                                confirmButtonText: "@lang('admin.OK')"
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;
                                        Swal.fire({
                                            text: "@lang('admin.Unexpected error.')",
                                            icon: "error",
                                            confirmButtonText: "@lang('admin.OK')"
                                        });
                                    });
                            }
                        });
                    });
                });
            }
            return {
                init: function () {
                    initAddlandSubmitLegal();
                }
            };
        }();
        KTUtil.onDOMContentLoaded(function () {
            KTLandsSubmitLegal.init();
        });



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
                @php
                    $attachments = $land->attachments()
                        ->where('reference_type', 'land')
                        ->where('attachment_type_cd', 45)
                        ->get();
                @endphp

                @if($attachments->count() > 0)
                @foreach($attachments as $file)
                var mockFile = { name: "{{ basename($file->file_path) }}", size: 123456, serverId: "{{ $file->id }}" };
                dz.emit("addedfile", mockFile);
                dz.emit("thumbnail", mockFile, "{{ asset('storage/'.$file->file_path) }}");
                dz.emit("complete", mockFile);

                mockFile.previewElement.querySelector("[data-dz-name]").innerHTML =
                    '<a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">{{ basename($file->file_path) }}</a>';
                @endforeach
                @endif


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

