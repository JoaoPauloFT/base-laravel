 <form id="formSubmit{{ $idItem }}" action="{{ $route }}" method="POST">
    @csrf()
    @if($isUpdate)
        @method('put')
    @endif
    <input type="text" name="form" value="formSubmit{{ $idItem }}" hidden>
    {{ $slot }}
    <button id="hide-submit" class="hidden"></button>
</form>

<script>
    window.addEventListener('load', function(){
        $("#saveChangesButton").on('click', function(){
            $("#hide-submit").trigger('click');
        });

        $('.input-form').on('keypress', function () {
            $(this).removeClass('errorField');
            $(this).parent().find('.messageError').remove();
        });
    });
</script>