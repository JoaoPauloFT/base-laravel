<div>
    <label for="{{ $field }}">{{ $name }}</label>
    <input id="{{ $field.$formId }}" name="{{ $field }}" placeholder="{{ $placeholder }}" class="input-form {{ $mask }} {{ $errors->has($field) && old('form') == 'formSubmit'.$formId ? 'errorField' : '' }}" type="{{ $type }}" value="{{ old('form') == 'formSubmit'.$formId ? old($field) : $value }}" {{ $customAttributes }}>
    @if($errors->has($field) && old('form') == 'formSubmit'.$formId)
        <p class="messageError">{{ $errors->first($field) }}</p>
    @endif
</div>
