@section('plugins.Mask', true)

<div>
    <x-forms.modal
        title="{{ $user->id ? __('message.edit_users') : __('message.add_users') }}"
        description="{{ $user->id ? __('message.description_edit_users') : __('message.description_users') }}"
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
            name="{{ __('message.name') }}"
            placeholder="{{ __('message.digit_name') }}"
            formId="{{ $user->id }}"
            value="{{ $user->name }}"
        />
        <x-forms.field
            field="email"
            name="Email"
            placeholder="{{ __('message.digit_email') }}"
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
            name="{{ __('message.role') }}"
            placeholder="{{ __('message.select_role') }}"
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
