<div>
    <x-forms.modal
        title="{{ $role->id ? 'Editar função' : 'Cadastrar função' }}"
        description="{{ $role->id ? 'Edita uma função cadastrado' : 'Cadastrar uma nova função' }}"
        route="{{ $role->id ? route('role.update', $role->id) : route('role.store') }}"
        textButtonConfirm="{{ $role->id ? __('message.edit') : __('message.register') }}"
        idModal="modalForm{{ $role->id }}"
        idItem="{{ $role->id }}"
    >
        @if($role->id)
            @method('PUT')
        @endif
        <x-forms.field
            field="name"
            name="Nome"
            placeholder="Digite o nome"
            formId="{{ $role->id }}"
            value="{{ $role->name }}"
        />
        <x-forms.field
            field="description"
            name="Descrição"
            placeholder="Digite a descrição"
            formId="{{ $role->id }}"
            value="{{ $role->description }}"
        />
        @if(!$role->id)
            <x-forms.select
                field="role_id"
                name="Função base"
                placeholder="Selecione uma função"
                :options="$roles"
                mask="search-select"
                formId="{{ $role->id }}"
            />
        @endif
    </x-forms.modal>
</div>
