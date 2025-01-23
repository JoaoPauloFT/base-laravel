<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<div class="modal fade" id="{{ $idModal }}" tabindex="-1" role="dialog" aria-labelledby="{{ $idModal }}">
    <div class="modal-dialog {{ $multiColumn ? "modal-dialog-multi-column" : "" }}">
            <div class="modal-content {{ $multiColumn ? "multi-column" : "" }}">
                <div class="header">
                    <div>
                        <h1>{{ $title }}</h1>
                        <div>
                            <i class="fa-solid fa-x" data-dismiss="modal"></i>
                        </div>
                    </div>
                    <p>{{ $description }}</p>
                </div>

                <div class="body-modal">
                    <form {{ $customForm }} id="formSubmit{{ $idItem }}" action="{{ $route }}" method="POST">
                        @csrf()
                        <input type="text" name="form" value="formSubmit{{ $idItem }}" hidden>
                        {{ $slot }}
                    </form>
                    @if($titleImage != "")
                        <x-forms.upload-image
                            title="{{ $titleImage }}"
                            width="{{ $width }}"
                            height="{{ $height }}"
                            idItem="{{ $idItem }}"
                            idModal="{{ $idModal }}"
                        />
                    @endif
                </div>
                <div class="footer">
                    <button type="button" class="secondary-button" data-dismiss="modal" onclick="{{ $cancelAction }}"> {{ $textButtonCancel }}</button>
                    <button type="button" class="primary-button submit" onclick="{{ $confirmAction }}">
                        {{ $textButtonConfirm }}
                        @if($iconButtonConfirm != '')
                            <img src="{{ $iconButtonConfirm }}">
                        @endif
                    </button>
                </div>
            </div>
    </div>
</div>
<script>
    function submit{{ $idItem }}() {
        $('#formSubmit{{ $idItem }}').submit();
    }

    window.addEventListener('load', function () {

        @if($errors->any() && old('form') == 'formSubmit'.$idItem)
            @if($idItem)
                document.getElementById('editButton{{ $idItem }}').click();
            @else
                document.getElementById('createButton').click();
            @endif

            @if($titleImage != "")
                @if($errors->has('image'))
                    document.querySelector('.drag-area').style.cssText = 'border: 1px dashed #E04B59 !important';
                    document.querySelector('.subdescription').style.cssText = 'color: #E04B59 !important';
                    document.querySelector('.subdescription').innerText = '{{ $errors->first('image') }}';
                @else
                    document.querySelector(".drag-area").innerHTML = "<img src='{{ old('image') }}' />";
                @endif
            @endif

            $('.input-form').on('select2:select', function () {
                $(this).data('select2').$container.removeClass('errorField');
                $(this).parent().find('.messageError').remove();
            });

            $('.input-form').on('keypress', function () {
                $(this).removeClass('errorField');
                $(this).parent().find('.messageError').remove();
            });
        @endif
    });
</script>
