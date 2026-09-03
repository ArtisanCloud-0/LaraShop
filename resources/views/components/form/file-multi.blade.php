@props([
    'for' => '',
    'label' => '',
    'images' => [],
    'newImages' => [],
])
<div class="mt-6 p-4 border border-slate-200 dark:border-slate-800 rounded-lg bg-slate-50 dark:bg-slate-900 transition-colors">
    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
        Product Media Portfolio
    </label>

    <div class="flex items-center justify-center w-full">
        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 dark:border-slate-800 rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 dark:bg-slate-950/30 hover:dark:bg-slate-950/60 transition-colors">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <p class="mb-2 text-sm text-slate-500 dark:text-slate-400">
                    <span class="font-semibold">Click to upload</span> or drag and drop
                </p>
                <p class="text-xs text-slate-400">PNG, JPG or WEBP up to 2MB</p>
            </div>

            <input 
                type="file" 
                wire:model="new_images" 
                class="hidden" 
                multiple 
                accept="image/jpeg,image/png,image/webp"
            />
        </label>
    </div>

    @error('new_images')
        <span class="text-xs text-red-600 dark:text-red-300 mt-1 block">{{ $message }}</span>
    @enderror
    @error('new_images.*')
        <span class="text-xs text-red-600 dark:text-red-300 mt-1 block">{{ $message }}</span>
    @enderror

    <div wire:loading wire:target="new_images" class="text-xs text-indigo-500 mt-2 font-mono">
        Uploading files...
    </div>

    <!-- Image Previews -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
        {{-- Existing Saved Images --}}
        @foreach($images as $index => $savedImage)
            @if(is_string($savedImage))
                <div class="relative group aspect-square border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-900">
                    <img src="{{ asset('storage/' . $savedImage) }}" alt="Product image" class="object-cover w-full h-full">
                    <button 
                        type="button" 
                        wire:click="removeImage({{ $index }})" 
                        class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition duration-150 shadow"
                    >
                        ✕
                    </button>
                </div>
            @endif
        @endforeach

        {{-- Newly Selected Temporary Images --}}
        @foreach($newImages as $tempImage)
            @if(is_object($tempImage) && method_exists($tempImage, 'temporaryUrl'))
                <div class="relative aspect-square border border-indigo-400/40 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-900 opacity-70">
                    <img src="{{ $tempImage->temporaryUrl() }}" alt="Pending image" class="object-cover w-full h-full">
                    <div class="absolute bottom-0 inset-x-0 bg-indigo-600 text-[10px] text-center text-white py-0.5">
                        Pending Save
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>