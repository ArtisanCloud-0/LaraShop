@props(['options' => [], 'for' => '', 'label' => ''])
<div>
    
    <label
        for="{{ $for }}"
        class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2"
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
            px-3
            py-2
            focus:outline-none
            focus:ring-2
            bg-slate-50 
            focus:bg-white 
            text-slate-500
            placeholder:text-slate-400
            dark:placeholder:text-slate-300
            @error('{{ $for }}') 
                text-red-700 ring-red-600
                dark:text-red-700 dark:ring-red-300 
            @else 
                border-slate-300 focus:border-slate-100 focus:ring-slate-300
                dark:border-slate-800 dark:focus:border-indigo-500 dark:focus:ring-indigo-500
            @enderror 
            dark:bg-slate-900
            dark:focus:bg-slate-950
            dark:text-slate-100
            transition-colors
        "
    >
        <option value="">-- None (Set as Root Category) --</option>
        @foreach($options as $option)
            <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    </select>

    @error("$for") 
        <span class="text-xs text-red-700 dark:text-red-300 mt-1 block">{{ $message }}</span> 
    @enderror

</div>