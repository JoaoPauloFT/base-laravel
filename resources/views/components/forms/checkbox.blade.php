<div class="check-box">
    <input id="{{ $field.$formId }}" name="{{ $field }}" type="checkbox" value="1" {{ $checked ? "checked" : "" }} data-old-value="{{ $checked ? "true" : "false" }}" {{ $customAttributes }}>
    @if($hasBoldName)
        <div>
            <label>{{ $name }}</label> <span class="bold-label">{{ $boldName }}</span>
        </div>
    @else
        <label for="{{ $field.$formId }}" class="form-check-label">{{ $name }}</label>
    @endif
</div>
