@props(['options' => $options, 'for' => $for, 'label' => $label])
<div>
    
    <label
        for="{{ $for }}"
        class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2"
    >
        {{ $label }}
    </label>
    
    <select
        id="{{ $for }}"
        wire:model.defer="{{ $for }}"
        class="
            w-full
            border
            rounded-lg
            px-4
            py-2.5
            focus:outline-none
            focus:ring-2
            bg-gray-100
            text-gray-500
            border-gray-300
            focus:ring-gray-300
            focus:border-gray-300
            dark:bg-gray-950
            dark:text-gray-100
            dark:border-gray-300
            dark:focus:ring-gray-300
            dark:focus:border-gray-300
        "
    >
        <option value="">-- None (Set as Root Category) --</option>
        @foreach($options as $option)
            <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    </select>

    @error("{{ $for }}") 
        <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> 
    @enderror

</div>