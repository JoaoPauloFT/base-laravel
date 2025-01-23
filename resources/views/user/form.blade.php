@section('plugins.Mask', true)

<div>
    <x-forms.modal
        title="{{ $user->id ? 'Editar funcionário' : 'Cadastrar funcionário' }}"
        description="{{ $user->id ? 'Edita um funcionário cadastrado' : 'Cadastrar um novo funcionário' }}"
        route="{{ $user->id ? route('user.update', $user->id) : route('user.store') }}"
        textButtonConfirm="{{ $user->id ? __('message.edit') : __('message.register') }}"
        idModal="modalForm{{ $user->id }}"
        idItem="{{ $user->id }}"
        titleImage="{{ __('message.upload_image_text') }}"
        width="200"
        height="200"
    >
        @if($user->id)
            @method('PUT')
        @endif
        <x-forms.field
            field="name"
            name="Nome"
            placeholder="Digite o nome do funcionário"
            formId="{{ $user->id }}"
            value="{{ $user->name }}"
        />
        <x-forms.field
            field="email"
            name="Email"
            placeholder="Digite o email do funcionário"
            type="email"
            formId="{{ $user->id }}"
            value="{{ $user->email }}"
        />
        @if(!$user->id)
            <x-forms.field-password
                generatePassword=true
            />
        @endif
        <x-forms.select
            field="role_id"
            name="Função"
            placeholder="Selecione uma função"
            :options="$roles"
            mask="search-select"
            formId="{{ $user->id }}"
            value="{{ $user->role_id }}"
        />
        <input id="image{{ $user->id }}" name="image" type="hidden" value="{{ old('form') == 'formSubmit'.$user->id ? old('image') : $user->image }}">
    </x-forms.modal>
</div>

@if($user->id)
    <script>
        window.addEventListener('load', function () {
        @if($user->image)
            document.querySelector(".drag-area{{ $user->id }}").innerHTML = "<img class='preview-img' src='{{ asset($user->image) }}' />";
        @endif
        });
    </script>
@endif
