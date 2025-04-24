<form id="formDelete{{ $formId }}{{ $id }}" action="{{route($route, [$id, $secondParam])}}" method="POST">
    @csrf()
    @method('DELETE')
    <button id="submitDelete{{ $formId }}{{ $id }}" type="button" class="btnAction">
        <i class="ti ti-trash"></i>
    </button>
</form>

<script>
    document.getElementById('submitDelete{{ $formId }}{{ $id }}').addEventListener('click', function () {
        Swal.fire({
            title: '{{ $title }}',
            text: '{{ __('message.dont_revert_operation') }}',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#042A56",
            cancelButtonColor: "#d33",
            confirmButtonText: '{{ __('message.yes') }}',
            cancelButtonText: '{{ __('message.cancel') }}',
            customClass: {
                confirmButton: 'primary-button',
                cancelButton: 'cancel-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formDelete{{ $formId }}{{ $id }}').submit();
            }
        });
    })
</script>
