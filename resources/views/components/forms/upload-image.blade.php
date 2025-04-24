@section('plugins.Crop', true)

<script>
    window.addEventListener('load', function () {
        const dropArea{{ $idItem }} = document.querySelector(".drag-area{{ $idItem }}"),
            input{{ $idItem }} = document.querySelector(".input-drag{{ $idItem }}");

        dropArea{{ $idItem }}.addEventListener("click", () => {
            input{{ $idItem }}.click();
        });

        input{{ $idItem }}.addEventListener("change", function (evt) {
            if(validFile(this.files[0])) {
                var tgt = evt.target || window.event.srcElement,
                    files = tgt.files;

                showCropBox{{ $idItem }}(files);
            }
        });

        dropArea{{ $idItem }}.addEventListener("dragover", (event) => {
            event.preventDefault();
            dropArea{{ $idItem }}.classList.add("active");
        });

        dropArea{{ $idItem }}.addEventListener("dragleave", (event) => {
            event.preventDefault();
            dropArea{{ $idItem }}.classList.remove("active");
        });

        dropArea{{ $idItem }}.addEventListener("drop", (event) => {
            event.preventDefault();
            if(validFile(event.dataTransfer.files[0])) {
                showCropBox{{ $idItem }}(event.dataTransfer.files);
            }

            dropArea{{ $idItem }}.classList.remove("active");
        });

        // Crop Image

        var $image = $('#thumb-box{{ $idItem }}');

        $image.cropper({
            viewMode: 2,
            @if($width > 0)
                aspectRatio: {{ $width }}/{{ $height }},
            @endif
        });

        var cropper = $image.data('cropper');

        $('.close-modal-image{{ $idItem }}').on('click', function () {
            $("#cropModal{{ $idItem }}").modal('hide');
            $("#modalForm{{ $idItem }}").modal('show');
        });

        $('#image-zoomin-button{{ $idItem }}').on('click', function () {
            cropper.zoom(0.1);
        });

        $('#image-zoomout-button{{ $idItem }}').on('click', function () {
            cropper.zoom(-0.1);
        });

        $('#image-rotatein-button{{ $idItem }}').on('click', function () {
            cropper.rotate(90);
        });

        $('#image-rotateout-button{{ $idItem }}').on('click', function () {
            cropper.rotate(-90);
        });

        $('#image-crop-button{{ $idItem }}').on('click', function () {
            thumbmailView();
            $("#cropModal{{ $idItem }}").modal('toggle');
            $("#modalForm{{ $idItem }}").modal('toggle');

        });

        function showCropBox{{ $idItem }}(files) {
            let imgsrc = URL.createObjectURL(files[0])
            if(imgsrc) {
                cropper.replace(imgsrc);

                $("#modalForm{{ $idItem }}").modal('hide');
                $("#cropModal{{ $idItem }}").modal('show');
            }
        }

        // Preview Image

        function thumbmailView() {
            cropper.getCroppedCanvas().toBlob((blob) => {
                const formData = new FormData();

                formData.append('file', blob);
                formData.append('width', {{ $width }});
                formData.append('height', {{ $height }});
                formData.append('maxSize', {{ $maxSize }});
                formData.append('path', '{{ $path }}');

                $.ajax('{{ route('FileUpload') }}', {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        document.querySelectorAll('.submit').forEach(function (e) {
                            e.disabled = true;
                        });
                    },
                    success: function (response) {
                        {{ $completeFunction }}(response);
                        document.querySelectorAll('.submit').forEach(function (e) {
                            e.disabled = false;
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        document.querySelectorAll('.submit').forEach(function (e) {
                            e.disabled = false;
                        });
                    }
                });
            });
        }

        function completeUpload{{ $idItem }}(response) {
            $('#preview-files{{ $idItem }}').append('<div class="img-preview"><img src="' + response.data['locale'] + '" alt="preview"><i class="ti ti-x remove-file" onclick="removeImage{{ $idItem }}(this, \'' + response.data['name'] + ',\')"></i></div>');
            document.querySelector('#{{ $field.$idItem }}').value += response.data['name'] + ",";
        }

        function validFile(file) {
            if (file.type === 'image/png' || file.type === 'image/jpeg'|| file.type === 'image/webp') {
                dropArea{{ $idItem }}.style.cssText = 'border: 1px dashed #E7E7E7 !important';
                document.querySelector('.subdescription{{ $idItem }}').style.cssText = 'color: #ADB5BD !important';
                document.querySelector('.subdescription{{ $idItem }}').innerText = '{{ __('message.image_formats') }}';
                return true;
            } else {
                input{{ $idItem }}.value = '';
                dropArea{{ $idItem }}.style.cssText = 'border: 1px dashed #E04B59 !important';
                document.querySelector('.subdescription{{ $idItem }}').style.cssText = 'color: #E04B59 !important';
                document.querySelector('.subdescription{{ $idItem }}').innerText = "{{ __('message.format_incorrect_response', ['format' => 'png/jpg/jpeg/webp']) }}";
                return false;
            }
        }
    });

    function removeImage{{ $idItem }}(element, image) {
        $(element).parent().remove();
        let value = $('#{{ $field.$idItem }}').val();
        $('#{{ $field.$idItem }}').val(value.replaceAll(image, ''));
    }
</script>

<div>
    {{ $slot }}
</div>

<div class="modal fade" id="cropModal{{ $idItem }}" tabindex="-1" role="dialog" aria-labelledby="cropModal">
    <div class="modal-dialog crop" role="document">
        <div class="modal-content crop">
            <div class="header">
                <div>
                    <div>
                        <h1>{{ __('message.crop_image') }}</h1>
                    </div>
                    <div class="min-content">
                        <i class="ti ti-x close-modal-image{{ $idItem }}"></i>
                    </div>
                </div>
                <p>{{ __('message.adjust_and_crop_image') }}</p>
            </div>
            <div class="body-modal">
                <div class="new-crop">
                    <img id="thumb-box{{ $idItem }}" src="" alt="Image to Crop">
                </div>
            </div>
            <div class="footer">
                <button id="image-rotateout-button{{ $idItem }}" type="button" class="secondary-button"><i class="ti ti-rotate-2"></i></button>
                <button id="image-rotatein-button{{ $idItem }}" type="button" class="secondary-button"><i class="ti ti-rotate-clockwise-2"></i></button>
                <button id="image-zoomout-button{{ $idItem }}" type="button" class="secondary-button"><i class="ti ti-minus"></i></button>
                <button id="image-zoomin-button{{ $idItem }}" type="button" class="secondary-button"><i class="ti ti-plus"></i></button>
                <button type="button" class="secondary-button close-modal-image{{ $idItem }}">{{ __('message.close') }}</button>
                <button id="image-crop-button{{ $idItem }}" type="button" class="primary-button">{{ __('message.crop') }}</button>
            </div>
        </div>
    </div>
</div>
