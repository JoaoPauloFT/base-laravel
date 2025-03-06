<div>
    <x-forms.modal
        title="{{ $role->id ? __('message.edit_roles') : __('message.add_roles') }}"
        description="{{ $role->id ? __('message.description_edit_roles') : __('message.description_roles') }}"
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
            name="{{ __('message.name') }}"
            placeholder="{{ __('message.digit_name') }}"
            formId="{{ $role->id }}"
            value="{{ $role->name }}"
        />
        <x-forms.field
            field="description"
            name="{{ __('message.description') }}"
            placeholder="{{ __('message.digit_description') }}"
            formId="{{ $role->id }}"
            value="{{ $role->description }}"
        />
        @if(!$role->id)
            <x-forms.select
                field="role_id"
                name="{{ __('message.base_role') }}"
                placeholder="{{ __('message.select_role') }}"
                :options="$roles"
                mask="search-select"
                formId="{{ $role->id }}"
            />
        @endif
    </x-forms.modal>
</div>
