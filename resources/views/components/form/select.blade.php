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
            py-3
            focus:outline-none
            focus:ring-2
            bg-gray-50 
            focus:bg-white 
            text-gray-500
            placeholder:text-gray-400
            dark:placeholder:text-slate-300
            @error("$for") 
                text-red-700 border-red-700 focus:border-red-700 focus:ring-red-700
                dark:text-red-300 dark:border-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 
            @else 
                border-gray-300 focus:border-gray-100 focus:ring-gray-300
                dark:border-gray-800 dark:focus:border-indigo-500 dark:focus:ring-indigo-500
            @enderror 
            dark:bg-gray-950
            dark:text-gray-100
            transition-colors
        "
    >
        <option value="">-- None (Set as Root Category) --</option>
        @foreach($options as $option)
            <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    </select>

    @error("$for") 
        <span class="text-xs text-red-700 dark:text-red-700 mt-1 block">{{ $message }}</span> 
    @enderror

</div>