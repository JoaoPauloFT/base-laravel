<div class="check-box" {{ $customAttributes }}>
    <input id="{{ $field.$formId }}" name="{{ $field }}" class="form-check-input" type="checkbox" value="1" {{ $checked ? "checked" : "" }}>
    <label for="{{ $field.$formId }}" class="form-check-label">{{ $name }}</label>
</div>
