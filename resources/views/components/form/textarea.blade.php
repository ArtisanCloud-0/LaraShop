@props(['for' => $for, 'label' => $label, 'placeholder' => $placeholder])

<div>

    <div>

        <label 
            class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2"
        >
            Product Detailed Description
        </label>

        <textarea 
            rows="4" 
            wire:model.defer="{{ $for }}"
            placeholder="{{ $placeholder }}" 
            class="
                w-full
                bg-gray-50
                dark:bg-slate-950
                border focus:bg-white
                border-gray-300 focus:border-gray-100 focus:ring-gray-300
                dark:border-gray-800 dark:focus:border-indigo-500 dark:focus:ring-indigo-500
                placeholder:text-gray-400
                dark:placeholder:text-slate-300
                rounded-lg
                p-4
                focus:ring-2
                focus:ring-gray-300
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