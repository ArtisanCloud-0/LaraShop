@props([
    'type' => 'text',
    'for' => null,
    'label' => '',
    'placeholder' => '',
])
<div>

    <label
        for="{{ $for }}"
        class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2"
    >
        {{ $label }}
    </label>
    
    <input
        type="{{ $type }}"
        id="{{ $for }}"
        wire:model.defer="{{ $for }}"
        class="
            w-full bg-slate-50 focus:bg-white 
            placeholder:text-slate-400
            dark:placeholder:text-slate-300
            ring-1
            @error('{{ $for }}') 
                text-red-700 ring-red-600
                dark:text-red-700 dark:ring-red-300 
            @else 
                ring-slate-300 focus:ring-slate-500
                dark:ring-slate-600 dark:focus:ring-slate-400
            @enderror 
            rounded-lg
            px-3
            py-2
            focus:outline-none
            focus:ring-2
            dark:text-slate-200
            dark:ring-slate-700
            dark:bg-slate-900
            dark:focus:bg-slate-950/50
            transition-colors
        "
        placeholder="{{ $placeholder }}"
    >

    @error("$for") 
        <span class="text-xs text-red-700 dark:text-red-300 mt-1 block">{{ $message }}</span> 
    @enderror

</div>
