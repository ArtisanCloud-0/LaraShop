<div>
    
    <div class="max-w-4xl mx-auto my-8 p-6 border rounded-xl shadow-md bg-gray-50 border-gray-200/50 text-gray-100 dark:bg-gray-900 dark:border-gray-800 dark:text-gray-100">
        
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-800 dark:border-gray-400">
            <h2 class="text-xl font-semibold tracking-tight text-gray-600 dark:text-gray-300">Add New Catalog Category</h2>
            <span class="text-xs text-gray-500 dark:text-gray-300 font-mono">Domain Validation Testing</span>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            @error('form_execution')
                <div class="p-4 bg-red-950/50 border border-red-800 text-red-400 text-sm rounded-lg">
                    {{ $message }}
                </div>
            @enderror
    
            {{-- Session Messages --}}
            <x-message.session></x-message.session>

            {{-- Categories Names --}}
            <x-form.input
                for="name"
                label="Category Name"
                placeholder="e.g., Electronics, Running Shoes"
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

            <div class="flex items-center justify-end gap-x-3 pt-4 border-t border-gray-800">
                
                <x-button.cancel target="panel.categories"></x-button.cancel>

                <x-button.execute></x-button.execute>

            </div>

        </form>

    </div>

</div>
