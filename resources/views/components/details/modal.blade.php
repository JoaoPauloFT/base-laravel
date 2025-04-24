<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<div class="modal fade" id="modalDetail{{ $idItem }}" tabindex="-1" role="dialog">
    <div class="modal-dialog {{ $classAdd }}">
        <div class="modal-content {{ $classAdd }}">
            <div class="header">
                <div>
                    <h1>{{ $title }}</h1>
                    <div onclick="{{ $cancelAction }}">
                        <i class="ti ti-x" data-dismiss="modal"></i>
                    </div>
                </div>
                @if($description)
                    <p>
                        {{ $description }}
                    </p>
                @endif
            </div>
            <div class="body-modal">
                {{ $slot }}
            </div>
            @if($hasFooter)
                <div class="footer">
                    <button type="button" class="secondary-button" data-dismiss="modal" onclick="{{ $cancelAction }}"> {{ $textButtonCancel }}</button>
                    {!! $buttonAdditional !!}
                    @if($hasConfirm)
                        <button type="button" class="primary-button submit" onclick="{{ $confirmAction }}">
                            {{ $textButtonConfirm }}
                            @if($iconButtonConfirm != '')
                                <img src="{{ $iconButtonConfirm }}">
                            @endif
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
