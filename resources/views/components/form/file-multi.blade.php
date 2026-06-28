@props(['for' => $for, 'label' => $label, 'filesTypes' => $filesTypes, 'images' => [], 'new_images' => []])

<div>

    <div class="mt-6 p-4 border border-gray-200 dark:border-slate-800 rounded-lg bg-gray-50 focus:bg-gray-50 dark:bg-slate-950 focus:dark:bg-slate-800">
        
        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">{{ $label }}</label>
        
        <div class="flex items-center justify-center w-full">
            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-slate-800 rounded-lg cursor-pointer bg-gray-50 dark:bg-slate-900 hover:bg-gray-100 dark:hover:bg-slate-850 transition">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-slate-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-400">{{ $filesTypes }}</p>
                </div>
                <input type="file" wire:model="{{ $for }}" class="hidden" multiple />
            </label>
        </div>
        @error("$for.*") <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

        <div wire:loading wire:target="{{ $for }}" class="text-xs text-indigo-500 mt-2 font-mono">
            Uploading file chunks to temporary storage engine...
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
            @foreach($images as $index => $savedImage)
                <div class="relative group aspect-square border border-gray-200 dark:border-slate-800 rounded-lg overflow-hidden bg-gray-100 dark:bg-slate-900">
                    <img src="{{ asset('storage/' . $savedImage) }}" class="object-cover w-full h-full">
                    <button type="button" wire:click="removeImage({{ $index }})" 
                        class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition duration-150 shadow" title="Delete Image">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            @endforeach

            @if ($new_images)
                @foreach($new_images as $tempImage)
                    <div class="relative aspect-square border border-indigo-400/40 rounded-lg overflow-hidden bg-gray-100 dark:bg-slate-900 opacity-70">
                        <img src="{{ $tempImage->temporaryUrl() }}" class="object-cover w-full h-full">
                        <div class="absolute bottom-0 inset-x-0 bg-indigo-600 text-[10px] text-center text-white py-0.5 font-sans">Pending Save</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>