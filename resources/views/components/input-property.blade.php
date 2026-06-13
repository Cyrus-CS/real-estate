<div @class(['form-group', $class])>
    <label for="{{ $name }}">{{ $label }}</label>

    @if($type === 'textarea')
    <textarea name="{{ $name }}" id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror">{{ old($name, $value) }}</textarea>
    @elseif ($type === 'file')
    <input type="file" name="{{ $name }}{{ $multiple ? '[]' : '' }}" id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror" {{ $multiple ? 'multiple' : '' }}>
    @else
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror" value="{{ old($name, $value) }}">
    @endif

    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>