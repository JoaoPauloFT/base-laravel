@section('plugins.Mask', true)

<div>
    <x-forms.modal
        title="{{ $user->id ? __('message.edit_users') : __('message.add_users') }}"
        description="{{ $user->id ? __('message.description_edit_users') : __('message.description_users') }}"
        route="{{ $user->id ? route('user.update', $user->id) : route('user.store') }}"
        textButtonConfirm="{{ $user->id ? __('message.edit') : __('message.register') }}"
        idModal="modalForm{{ $user->id }}"
        idItem="{{ $user->id }}"
        iconButtonConfirm="{{$user->id ? 'ti ti-checks' : ''}}"
        cancelAction="{{$user->id ? '' : ' clean_modal()'}}"
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
        <div>
            <label for="file{{ $user->id }}">{{ __('message.image') }}</label>
            <div>
                <div class="drag-area{{ $user->id }} divImage {{ $errors->has('image') && old('form') == 'formSubmit'.$user->id ? 'error' : '' }}">
                    <i class="ti ti-upload"></i>
                    <span>{{ __('message.upload_image_description') }}</span>
                </div>
                <input id="input-drag{{ $user->id }}" class="input-drag{{ $user->id }}" type="file" accept="image/png, image/jpeg, image/webp" hidden>
            </div>
            <p class="subdesc subdescription{{ $user->id }} {{ $errors->has('image') && old('form') == 'formSubmit'.$user->id ? 'messageError' : '' }}">{{ $errors->has('image') && old('form') == 'formSubmit'.$user->id ? ucfirst($errors->first('image')) : __('message.image_formats') }}</p>
        </div>
        <div id="preview-files{{ $user->id }}" class="preview-files">
            @if(old('image') || $user->image)
                <div class="img-preview">
                    <img src="{{ asset(old('image') ?? $user->image) }}" alt="{{ old('image') ?? $user->image }}">
                </div>
            @endif
        </div>
    </x-forms.modal>
    <x-forms.upload-image
        width="200"
        height="200"
        idItem="{{ $user->id }}"
        idModal="modalForm{{ $user->id }}"
        completeFunction="completeUploadSignature{{ $user->id }}"
        path="images/avatar"
    />
</div>

<script>
    function completeUploadSignature{{ $user->id }}(response) {
        $('#preview-files{{ $user->id }}').html("<div class='img-preview'><img class='preview-img' src='" + response.data['locale'] + "' alt='" + response.data['name'] + "' /></div>");
        document.querySelector('#image{{ $user->id }}').value = response.data['path'];
    }
</script>
