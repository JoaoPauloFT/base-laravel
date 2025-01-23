@section('plugins.Crop', true)

<script>
    window.addEventListener('load', function () {
        const dropArea{{ $idItem }} = document.querySelector(".drag-area{{ $idItem }}"),
            input{{ $idItem }} = document.querySelector(".input-drag{{ $idItem }}");

        dropArea{{ $idItem }}.addEventListener("click", () => {
            input{{ $idItem }}.click();
        });

        input{{ $idItem }}.addEventListener("change", function () {
            showCropBox{{ $idItem }}(this);
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
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(event.dataTransfer.files[0]);
            if (dataTransfer.files[0].type === 'image/png' || dataTransfer.files[0].type === 'image/jpeg') {
                input{{ $idItem }}.files = dataTransfer.files;
                showCropBox{{ $idItem }}(input{{ $idItem }});
            } else {
                setError('{{ __('message.format_incorrect_response', ['format' => 'png ou jpg/jpeg']) }}')
            }

            dropArea{{ $idItem }}.classList.remove("active");
        });

        function uploadImage() {
            var file = input{{ $idItem }}.files[0];
            var formData = new FormData();
            formData.append('file', file);
            formData.append('width', {{ $width }});
            formData.append('height', {{ $height }});

            $.ajax('{{ route('FileUpload') }}', {
                type: 'POST',
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    document.querySelectorAll('.submit').forEach(function (e) {
                        e.disabled = true;
                    });
                },
                success: function (response) {
                    document.querySelector('#image{{ $idItem }}').value = response.data['nameImage'];
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
        }

        function thumbmailView(file) {
            const image = new File([file],"img.png",{type:"image/png",lastModified:new Date().getTime()});
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(image);
            input{{ $idItem }}.files=dataTransfer.files;

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (readEvent) {
                const img = new Image();
                img.src = readEvent.target.result;
                img.onload = function () {
                    var result = validSize(img, {{ $width }}, {{ $height }});

                    if (result) {
                        dropArea{{ $idItem }}.innerHTML = "<img class='preview-img' src='" + readEvent.target.result + "' />";
                        document.querySelector('.drag-area{{ $idItem }}').style.cssText = 'border: 1px dashed #E7E7E7 !important';
                        document.querySelector('.subdescription{{ $idItem }}').style.cssText = 'color: #CECBD0 !important';
                        document.querySelector('.subdescription{{ $idItem }}').innerText = '{{ __('message.image_size', ['size' => $width.'x'.$height]) }}';

                        uploadImage();
                    } else {
                        setError('{{ __('message.size_incorrect_response', ['size' => $width.'x'.$height]) }}');
                    }
                }
            }
        }

        function validSize(file, width, height) {
            return file.width === width && file.height === height;
        }

        function setError(messageError) {
            input{{ $idItem }}.value = '';
            dropArea{{ $idItem }}.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60" fill="none">
                    <path d="M22.5 40H37.5V25H47.5L30 7.5L12.5 25H22.5V40ZM12.5 45H47.5V50H12.5V45Z" fill="#CECBD0"/>
                </svg>
                <span>{{ __('message.upload_image_description') }}</span>
            `;

            document.querySelector('.drag-area{{ $idItem }}').style.cssText = 'border: 1px dashed #E04B59 !important';
            document.querySelector('.subdescription{{ $idItem }}').style.cssText = 'color: #E04B59 !important';
            document.querySelector('.subdescription{{ $idItem }}').innerText = messageError;
        }

        // Crop Image

        var options = {
            thumbBox: '#thumb-box{{ $idItem }}',
            spinner: '.spinner',
            imgSrc: ''
        };

        var cropper = $('#crop-box{{ $idItem }}').cropbox(options);

        function showCropBox{{ $idItem }}(element) {
            var $selector = $(element),
                file = element.files ? element.files[0] : "";

            if (file) {

                var height = {{ $height }},
                    width = {{ $width }},
                    parentHeight = ({{ $height }} + 100),
                    parentWidth = ({{ $width }} + 100);

                if (typeof FileReader == 'function') {

                    $(options.thumbBox).css({"width": width + "px", "height": height + "px", "margin-top": (height / 2) * -1 + "px", "margin-left": (width / 2) * -1 + "px"});
                    $('.crop').css({"width": parentWidth + "px", "max-width": parentWidth + "px"});
                    $('.crop-box').css({height: parentHeight + "px"});
                    $('#crop-box{{ $idItem }}').css({height: parentHeight + "px"});

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        options.imgSrc = e.target.result;
                        cropper = $('#crop-box{{ $idItem }}').cropbox(options);
                    };
                    reader.readAsDataURL(file);

                    setTimeout(function () {
                        $("#cropModal{{ $idItem }}").modal('toggle');

                        setTimeout(function () {
                            cropper.zoomIn();
                            cropper.zoomOut();
                        }, 500);
                    }, 500);

                    $selector.val("");
                }
            }
        }

        $('#image-crop-button{{ $idItem }}').on('click', function () {
            thumbmailView(cropper.getBlob());
            $("#cropModal{{ $idItem }}").modal('toggle');
        });

        $('#close-modal-image{{ $idItem }}').on('click', function () {
            $("#cropModal{{ $idItem }}").modal('toggle');
        });

        $('#image-zoomin-button{{ $idItem }}').on('click', function () {
            cropper.zoomIn();
        });

        $('#image-zoomout-button{{ $idItem }}').on('click', function () {
            cropper.zoomOut();
        });
    });
</script>

<div class="mt-3">
    <label>{{ $title }}</label>
    <div>
        <div class="drag-area{{ $idItem }} divImage">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60" fill="none">
                <path d="M22.5 40H37.5V25H47.5L30 7.5L12.5 25H22.5V40ZM12.5 45H47.5V50H12.5V45Z" fill="#CECBD0"/>
            </svg>
            <span>{{ __('message.upload_image_description') }}</span>
        </div>
        <input class="input-drag{{ $idItem }}" type="file" accept="image/png, image/jpeg" hidden>
    </div>
    <p class="subdesc subdescription{{ $idItem }}">{{ __('message.image_size', ['size' => $width.'x'.$height]) }}</p>
</div>

<div class="modal fade" id="cropModal{{ $idItem }}" tabindex="-1" role="dialog" aria-labelledby="cropModal">
    <div class="modal-dialog crop" role="document">
        <div class="modal-content crop">
            <div class="header">
                <div>
                    <h1>Cortar a imagem</h1>
                    <div>
                        <i class="fa-solid fa-x" data-dismiss="modal"></i>
                    </div>
                </div>
                <p>Ajuste e corte a imagem de acordo com o desejado</p>
            </div>
            <div class="body-modal">
                <div id="crop-box{{ $idItem }}" class="crop-box">
                    <div id="thumb-box{{ $idItem }}" class="thumb-box"></div>
                    <div class="spinner" style="display: none">Loading...</div>
                </div>
            </div>
            <div class="footer">
                <button id="image-zoomout-button{{ $idItem }}" type="button" class="secondary-button"><i class="fa-solid fa-minus"></i></button>
                <button id="image-zoomin-button{{ $idItem }}" type="button" class="secondary-button"><i class="fa-solid fa-plus"></i></button>
                <button id="close-modal-image{{ $idItem }}" type="button" class="secondary-button">Fechar</button>
                <button id="image-crop-button{{ $idItem }}" type="button" class="primary-button">Cortar</button>
            </div>
        </div>
    </div>
</div>
