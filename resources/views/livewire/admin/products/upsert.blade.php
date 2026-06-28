<div>
    <div class="max-w-4xl mx-auto my-8 p-6 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl transition-colors duration-200">
        
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-slate-800">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100">
                    {{ $isEditMode ? 'Modify Product Specifications' : 'Add New Catalog Product' }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">From here you can {{ $isEditMode ? 'update old' : 'insert new' }} products data</p>
            </div>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            @error('form_failure')
                <div class="p-4 bg-red-100 dark:bg-red-950/40 border border-red-300 dark:border-red-900 text-red-700 dark:text-red-400 text-sm rounded-lg">
                    {{ $message }}
                </div>
            @enderror

            <x-message.session></x-message>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <x-form.input
                    for="name"
                    label="Product Title Name"
                    placeholder="Product Title Name"
                ></x-form>

                <x-form.select
                    for="category_id"
                    label="Parent Category Mapping"
                    :options="$categories"
                ></x-form>

                <x-form.radio
                    for="is_visible"
                    title="Visible on Customer Storefront or hidden"
                ></x-form>

            </div>

            <x-form.textarea
                for="descripiton"
                label="Product Detailed Description"
                placeholder="You can write it as plantext or use HTML markup langages tags"
            ></x-form>

            <x-form.file-multi
                for="new_images"
                label="Product Media Portfolio (JSON Cast)"
                filesTypes="PNG, JPG or WEBP up to 2MB"
                :images="$images"
            ></x-form>

            <div class="flex items-center justify-end gap-x-4 pt-4 border-t border-gray-200 dark:border-slate-800">
                
                <a href="{{ route('panel.products') }}" class="text-sm font-semibold text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 transition-colors">
                    Back to Index
                </a>
                
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg shadow transition-all">
                    {{ $isEditMode ? 'Update Product Dataset' : 'Publish Product Line' }}
                </button>

            </div>

        </form>
    </div>
</div>