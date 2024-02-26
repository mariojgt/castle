<div class="form-control">
    <label class="label">
        <span class="label-text font-bold text-lg">{{ $label ?? 'undefine' }}</span>
    </label>
    <input class="input input-primary input-bordered text-lg font-mono" type="{{ $type ?? 'text' }}" name="{{ $name ?? 'name' }}" id="{{ $id ?? $name }}"
        {{ $required ?? '' == 'true' ? 'required' : '' }} value="{{ $value ?? old($name) }}"
        placeholder="{{ $placeholder ?? '' }}">
    @error($name)
        <span class="invalid-feedback text-error mt-4 text-center" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
