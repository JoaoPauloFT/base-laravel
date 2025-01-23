<div>
    <div class="commission">
        <input type="text" name="min_value_{{ $commission }}" value="{{ old('min_value_'.$commission) ?? $value['min_value_'.$commission] }}" class="form-control money">
        <span>até</span>
        <input type="text" name="max_value_{{ $commission }}" value="{{ old('max_value_'.$commission) ?? $value['max_value_'.$commission] }}" class="form-control money">
        <span>:</span>
        <input type="text" name="percent_{{ $commission }}" value="{{ old('percent_'.$commission) ?? $value['percent_'.$commission] }}" class="form-control percent">
    </div>
    @if($errors->has("min_value_".$commission))
        <p class="messageError">{{ $errors->first("min_value_".$commission) }}</p>
    @endif
    @if($errors->has("max_value_".$commission))
        <p class="messageError">{{ $errors->first("max_value_".$commission) }}</p>
    @endif
    @if($errors->has("percent_".$commission))
        <p class="messageError">{{ $errors->first("percent_".$commission) }}</p>
    @endif
</div>
