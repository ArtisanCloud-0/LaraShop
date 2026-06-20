<div>
    <div 
        class="
            p-6
            my-8
            border
            mx-auto
            shadow-md
            max-w-4xl
            rounded-xl
        
            bg-gray-50
            text-gray-600
            border-gray-100
        
            dark:bg-slate-900
            dark:text-slate-100
            dark:border-slate-800
        "
    >
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-300 dark:border-slate-800">
            <div>
                <h2 class="text-xl font-semibold tracking-tight">Edit Category: <span class="text-indigo-500 dark:text-indigo-400">{{ $category->name }}</span></h2>
                <p class="text-xs text-gray-400 dark:text-slate-400 mt-1 font-mono">Modifying Row ID: {{ $category->id }}</p>
            </div>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            @error('form_execution')
                <div class="p-4 bg-red-950/50 border border-red-800 text-red-400 text-sm rounded-lg">
                    {{ $message }}
                </div>
            @enderror

            <x-form.input
                for="name"
                placeholder="e.g., Electronics, Running Shoes"
                label="Category Name"
            ></x-form.input>

            {{-- Categories Parent --}}
            <x-form.select
                :options="$parentCategories"
                for="parent_id"
                label="Parent Category (Optional)"
            ></x-form.select>

            {{-- Make the category visible --}}
            <x-form.checkbox
                id="is_visible"
                for="is_visible"
                option="Visible on Storefront"
                note="If unchecked, this section along with its nested variant line items will be hidden from shoppers."
            ></x-form.checkbox>

            <div class="flex items-center justify-end gap-x-3 pt-4 border-t border-gray-300 dark:border-slate-800">

                <x-button.cancel target="panel.categories"></x-button.cancel>

                <x-button.execute></x-button.execute>

            </div>

        </form>
    
    </div>

</div>