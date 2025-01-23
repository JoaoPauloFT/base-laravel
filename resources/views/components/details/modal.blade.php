<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<div class="modal fade" id="modalDetail{{ $idItem }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-multi-column">
        <div class="modal-content multi-column">
            <div class="header">
                <div>
                    <h1>{{ $title }}</h1>
                    <div>
                        <i class="fa-solid fa-x" data-dismiss="modal"></i>
                    </div>
                </div>
            </div>
            <div class="body-modal">
                {{ $slot }}
            </div>
            @if($isFooter)
                <div class="footer">
                    {!! $buttonAdditional !!}
                    <button type="button" class="secondary-button" data-dismiss="modal" onclick="{{ $cancelAction }}"> {{ $textButtonCancel }}</button>
                    <button type="button" class="primary-button submit" onclick="{{ $confirmAction }}">
                        {{ $textButtonConfirm }}
                        @if($iconButtonConfirm != '')
                            <img src="{{ $iconButtonConfirm }}">
                        @endif
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
