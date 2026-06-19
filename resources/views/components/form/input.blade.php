@props(['for' => $for, 'label' => $label, 'placeholder' => $placeholder])
<div>

    <label
        for="{{ $for }}"
        class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2"
    >
        {{ $label }}
    </label>
    
    <input
        type="text"
        id="{{ $for }}"
        wire:model.defer="{{ $for }}"
        class="
            w-full bg-gray-100/50 border 
            @error('{{ $for }}') 
                border-red-500 focus:border-red-500 focus:ring-red-500 
            @else 
                border-gray-300 focus:border-gray-100 focus:ring-gray-300
                dark:border-gray-800 dark:focus:border-indigo-500 dark:focus:ring-indigo-500
            @enderror 
            rounded-lg
            px-4
            py-2.5
            text-gray-500
            focus:outline-none
            focus:ring-2
            dark:bg-gray-950
            dark:text-gray-100
        "
        placeholder="{{ $placeholder }}"
    >

    @error('{{ $for }}') 
        <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> 
    @enderror

</div>
