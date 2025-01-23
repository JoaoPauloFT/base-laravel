<div class="value {{$value == '0.00' ? 'new open'.$name : '' }}">
    @if($value == '0.00')
        <a id="btnNew{{ $name }}" href="#" data-toggle="modal" data-target="#edit{{ $name }}" class="btnAction edit"></a>
        <div class="newValue">
            <i class="fa-solid fa-plus br"></i>
            <p>{{ __('message.new_value') }}</p>
        </div>
    @else
        @can('edit_value_config')
            <a id="btn{{ $name }}" href="#" data-toggle="modal" data-target="#edit{{ $name }}" class="btnAction edit">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            {{ \App\Http\Controllers\ConfigController::edit_value($name, $value) }}
        @endcan
        @can('delete_value_config')
            <x-forms.delete-button
                route="config.delete"
                id="{{ $name }}"
                title="{{ __('message.title_delete_value') }}"
            />
        @endcan
        <p>R$ {{ number_format($value) }}</p>
    @endif
</div>
@if($value == '0.00')
    {{ \App\Http\Controllers\ConfigController::new_value($name) }}
    <script>
        window.addEventListener('load', function () {
            $('.open{{ $name }}').on('click', function () {
                document.querySelector('#btnNew{{ $name }}').click();
            })
        });
    </script>
@endif
