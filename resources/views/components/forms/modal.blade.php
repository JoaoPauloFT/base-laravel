<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<div class="modal fade" id="{{ $idModal }}" tabindex="-1" role="dialog" aria-labelledby="{{ $idModal }}">
    <div class="modal-dialog {{ $classAdd }}">
            <div class="modal-content {{ $classAdd }}">
                <div class="header">
                    <div>
                        <h1>{{ $title }}</h1>
                        <div>
                            <i class="ti ti-x" data-dismiss="modal" onclick="{{ $cancelAction }}"></i>
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
                </div>
                <div class="footer">
                    <button type="button" class="secondary-button" data-dismiss="modal" onclick="{{ $cancelAction }}"> {{ $textButtonCancel }}</button>
                    {!! $buttonAdditional !!}
                    <button type="button" class="primary-button submit" onclick="{{ $confirmAction }}">
                        @if($iconButtonConfirm != '')
                            <i class="{{ $iconButtonConfirm }}"></i>
                        @endif
                       {{ $textButtonConfirm }}
                    </button>
                </div>
            </div>
    </div>
</div>
<script>
    function submit{{ $idItem }}() {
        $('#formSubmit{{ $idItem }}').submit();
    }

    function submitAjax{{ $idItem }}(){
        $.ajax("{{ $route }}", {
            type: 'POST',
            dataType: 'json',
            data: $('#formSubmit{{ $idItem }}').serializeArray(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $("button[onclick='submitAjax{{ $idItem }}()']").prop('disabled', true);
            },
            success: function (response) {
                location.reload();
            },
            error: function (response) {
                $("button[onclick='submitAjax{{ $idItem }}()']").prop('disabled', false);
                const errors = response.responseJSON.errors;
                let element = "";
                for (let field in errors){
                    element = $("#"+field+"{{ $idItem }}");
                    switch(element.prop("tagName").toLowerCase()){
                        case "input":
                            $(element).addClass('errorField');
                            $(element).parent().find('.messageError').remove();
                            $(element).parent().append('<p class="messageError">'+errors[field]+'</p>');
                            break;

                        case "select":
                            $(element).parent().find('span').addClass('errorField');
                            $(element).parent().find('.messageError').remove();
                            $(element).parent().append('<p class="messageError">'+errors[field]+'</p>');
                            break;
                    }
                }
            }
        });
    }

    function clean_modal{{ $idItem }}(){
        $('#formSubmit{{ $idItem }} input:not(.signature-dropbox)').each(function() {
            if ($(this).attr('type') !== 'hidden' && $(this).attr('type') !== 'radio' && $(this).attr('name') !== 'form'){
                $(this).val('').trigger('change').click();
                $(this).removeClass("errorField"); //Remove a border-color do erro
            }
        });

        $('#formSubmit{{ $idItem }} textarea').each(function() {
            if ($(this).attr('type') !== 'hidden' && $(this).attr('name') !== 'form'){
                $(this).val('').trigger('change').click();
                $(this).removeClass("errorField"); //Remove a border-color do erro
            }
        });

        // Dispara um clique no select para limpar seu valor
        $('#formSubmit{{ $idItem }} select').each(function() {
            $(this).val('').trigger('change').click();
            $('span.errorField').removeClass('errorField'); //Remove a border-color do erro
        });

        //Remove a mensagem do erro dos inputs
        $("#formSubmit{{ $idItem }} .messageError").each(function(){
            $(this).remove();
        });

        $(".daterangepicker").hide();

        $('.preview-image').addClass('hidden');
        $('.upload-signature-field').removeClass('hidden');
        $('.signature-input').val('');
        $('.church-checkbox').prop('checked', false).trigger('change');

    }

    function recover_data{{ $idItem }}(data) {
        var idForm = "#formSubmit{{ $idItem }} input, #formSubmit{{ $idItem }} textarea, #formSubmit{{ $idItem }} select";
        var notFields = "input[name='_token'], input[name='_method'], input[name='form']";
        $(idForm).not(notFields).each(function() {
            var inputName = $(this).attr('name');
            var id = $(this).attr('id');
            if($(this).is('select')) {
                $("#" + id + " option[value='" + data[inputName] + "']").prop('selected', true);
            } else {
                $("#" + id).val(data[inputName]);
            }
            //Removendo os erros da tela
            $(this).removeClass("errorField");
        });

        $("#formSubmit{{ $idItem }} .messageError").each(function(){
            $(this).remove();
        });
    }

    @if($confirmAction == 'submitAjax'.$idItem.'()')
        $('#modalForm{{ $idItem }}').on('shown.bs.modal', function (e) {
    @else
        window.addEventListener('load', function (){
    @endif
        @if($errors->any() && old('form') == 'formSubmit'.$idItem)
            $("#{{ $idModal }}").modal('show');
        @endif

        $('.select-form').on('select2:select', function () {
            $(this).data('select2').$container.removeClass('errorField');
            $(this).parent().find('.messageError').remove();
        });

        $('.input-form').on('keypress', function () {
            $(this).removeClass('errorField');
            $(this).parent().find('.messageError').remove();
        });

        $('.field-passowrd').on('keypress', function () {
            var name = $(this).attr('name');
            $(this).removeClass('errorField');
            $('.passwordError'+name).remove();
        });
    });
</script>
