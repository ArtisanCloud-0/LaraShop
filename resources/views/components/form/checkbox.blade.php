@props([ 'option' => [], 'note' => '', 'for' => '', 'id' => null, ])
<div>
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input
                id="{{ $id }}"
                type="checkbox"
                wire:model.defer="{{ $for }}"
                class="w-4 h-4 text-slate-600 dark:text-slate-200 bg-slate-950 border-slate-800 rounded focus:ring-slate-500 focus:ring-offset-slate-900 focus:ring-2"
            />
        </div>

        <div class="ml-3 text-sm">
            <label
                for="{{ $id }}"
                class="font-medium text-slate-600 dark:text-slate-300"
                >{{ $option }}</label
            >

            <p class="text-slate-500 dark:text-slate-300 text-xs">
                {{ $note }}
            </p>
        </div>
    </div>
</div>
