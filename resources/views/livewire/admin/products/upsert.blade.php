<div class="max-w-5xl mx-auto my-8 p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl transition-all">

    <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-200 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                {{ $isEditMode ? 'Modify Product Specifications' : 'Add New Catalog Product' }}
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Configure core catalog fields, availability visibility, and primary cover image.
            </p>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 text-red-700 dark:text-red-400 text-xs rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <x-form.input
                for="name"
                placeholder="e.g. Mechanical Gaming Keyboard"
                label="Product Title Name" 
            />

            <x-form.select
                for="category_id"
                label="Parent Category Mapping"
                :options="$categories"
                placeholder="Select a Category" 
            />

        </div>

        <div class="p-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-between">
            <div>
                <h4 class="text-xs font-semibold text-slate-700 dark:text-slate-300">Catalog Visibility</h4>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">Toggle whether this item is published on public storefront searches.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model="is_visible" class="sr-only peer">
                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
            </label>
        </div>

        <x-form.textarea
            for="description"
            label="Product Detailed Description"
            placeholder="Write full specifications..."
        />

        <!-- Single Primary Cover Image Uploader -->
        <div class="p-4 border border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50 dark:bg-slate-900">
            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Primary Cover Image (Catalog Cards)</label>
            
            <div class="flex items-center gap-6">
                @if($new_cover_image && method_exists($new_cover_image, 'temporaryUrl'))
                    <div class="relative group w-28 h-28 border-2 border-indigo-500 rounded-xl overflow-hidden shrink-0">
                        <img src="{{ $new_cover_image->temporaryUrl() }}" class="object-cover w-full h-full" alt="New Cover Preview">
                        <button type="button" wire:click="$set('new_cover_image', null)" class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition shadow">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @elseif($cover_image)
                    <div class="relative group w-28 h-28 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shrink-0">
                        <img src="{{ asset('storage/' . $cover_image) }}" class="object-cover w-full h-full" alt="Current Cover Image">
                        <button type="button" wire:click="removeCoverImage" class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition shadow">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                <div class="flex-1">
                    <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-slate-300 dark:border-slate-800 rounded-xl cursor-pointer bg-white dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition">
                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                            <svg class="w-6 h-6 mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-xs text-slate-500 dark:text-slate-400"><span class="font-semibold">Select primary cover photo</span></p>
                            <p class="text-[10px] text-slate-400 mt-0.5">PNG, JPG or WEBP up to 2MB</p>
                        </div>
                        <input type="file" wire:model="new_cover_image" class="hidden" accept="image/jpeg,image/png,image/webp" />
                    </label>
                </div>
            </div>

            @error('new_cover_image') <span class="text-red-500 text-[11px] mt-1 block">{{ $message }}</span> @enderror

            <div wire:loading wire:target="new_cover_image" class="text-xs text-indigo-500 mt-2 font-mono">
                Uploading cover image...
            </div>
        </div>

        <div class="flex items-center justify-end gap-x-4 pt-4 border-t border-slate-200 dark:border-slate-800">
            <a href="{{ route('panel.products') }}" class="text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-slate-700 transition">
                Cancel
            </a>
            <button 
                type="submit" 
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl shadow-lg shadow-indigo-600/20 transition duration-150"
            >
                {{ $isEditMode ? 'Update Product Dataset' : 'Publish Product Line' }}
            </button>
        </div>

    </form>
</div>