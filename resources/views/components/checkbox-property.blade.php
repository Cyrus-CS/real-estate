<div class="form-check form-switch {{ $class ?? '' }}">
    <input type="checkbox" name="{{ $name }}" id="{{ $id ?? $name }}"
        class="form-check-input @error($name) is-invalid @enderror" value="1" {{ old($name, $value) ? 'checked' : '' }}>

    <label class="form-check-label" for="{{ $id ?? $name }}">
        {{ $label }}
    </label>

    @error($name)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
</div>