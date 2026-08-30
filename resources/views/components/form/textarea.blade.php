@props(['for' => '', 'label' => '', 'placeholder' => ''])

<div>

    <div>

        <label 
            class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2"
        >
            Product Detailed Description
        </label>

        <textarea 
            rows="4" 
            wire:model.defer="{{ $for }}"
            placeholder="{{ $placeholder }}" 
            class="
                w-full
                bg-slate-50
                dark:text-slate-100
                dark:bg-slate-900
                dark:focus:bg-slate-950
                border focus:bg-white
                border-slate-300 focus:border-slate-100
                dark:border-slate-800 dark:focus:border-indigo-500 dark:focus:ring-indigo-500
                placeholder:text-slate-400
                dark:placeholder:text-slate-300
                rounded-lg
                p-4
                focus:ring-2
                focus:ring-slate-300
                outline-none
                transition-colors
            "
        ></textarea>

        @error("$for") 
            <span class="text-xs text-red-500 mt-1 block">
                {{ $message }}
            </span> 
        @enderror

    </div>
    
</div>