<div>
    <select {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full']) }}>
        <option value="">{{ $placeholder ?? 'Pilih' }}</option>
        @foreach($options as $option)
            <option value="{{ $option['value'] }}" {{ $attributes['value'] == $option['value'] ? 'selected' : '' }}>
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
    @enderror
</div>
