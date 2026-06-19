@props([
    'option' => $option,
    'note' => $note,
    'for' => $for,
    'id' => $id,
])
<div>
    <div class="flex items-start">

        <div class="flex items-center h-5">

            <input
                id="{{ $id }}"
                type="checkbox"
                wire:model.defer="{{ $for }}" 
                class="
                    w-4
                    h-4
                    text-gray-600
                    dark:text-gray-200
                    bg-gray-950
                    border-gray-800 
                    rounded
                    focus:ring-gray-500
                    focus:ring-offset-gray-900
                    focus:ring-2
                "
            >
        
        </div>

        <div class="ml-3 text-sm">
        
            <label for="{{ $id }}" class="font-medium text-gray-600 dark:text-gray-300">{{ $option }}</label>
        
            <p class="text-gray-500 dark:text-gray-300 text-xs">{{ $note }}</p>
        
        </div>

    </div>

</div>