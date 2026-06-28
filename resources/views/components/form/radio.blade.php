@props(['for' => $for, 'title' => $title])

<div>

    <div class="flex items-center h-full pt-6">

        <label class="inline-flex items-center cursor-pointer">
        
            <input type="checkbox" wire:model.defer="{{ $for }}" class="sr-only peer">
        
            <div 
                class="
                    w-11 h-6 bg-gray-300 dark:bg-slate-800 peer-focus:outline-none 
                    rounded-full peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white after:content-[''] 
                    after:absolute after:top-[2px] after:left-[2px] after:bg-white 
                    after:border-gray-300 after:border after:rounded-full after:h-5 
                    after:w-5 after:transition-all peer-checked:bg-indigo-600 relative
                "
            ></div>
        
            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-slate-300">{{ $title }}</span>
        
        </label>
    
    </div>
        
</div>