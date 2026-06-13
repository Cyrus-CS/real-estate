@if($compact)
{{-- Mode filtre : pas de label, pas de wrapper --}}
<select name="{{ $name }}{{ $multiple ? '[]' : '' }}" id="{{ $name }}"
    class="form-select @error($name) is-invalid @enderror" {{ $multiple ? 'multiple' : '' }}>

    @if($placeholder)
    <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $key => $option)
    <option value="{{ $key }}" @if($multiple) @selected(in_array($key, (array) old($name, $value ?? []))) @else
        @selected(old($name, $value)==$key) @endif>
        {{ $option }}
    </option>
    @endforeach

</select>
@else
{{-- Mode formulaire : avec label et wrapper --}}
<div @class(['form-group', $class])>
    <label for="{{ $name }}">{{ $label }}</label>

    <select name="{{ $name }}{{ $multiple ? '[]' : '' }}" id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror" {{ $multiple ? 'multiple' : '' }}>

        @if($placeholder)
        <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $key => $option)
        <option value="{{ $key }}" @if($multiple) @selected(in_array($key, (array) old($name, $value ?? []))) @else
            @selected(old($name, $value)==$key) @endif>
            {{ $option }}
        </option>
        @endforeach

    </select>

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@endif