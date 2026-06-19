<div>

    <button 
        type="{{ $type ?? "submit" }}"
        class="
            inline-flex
            items-center
            px-5
            py-2
            text-sm
            font-medium 
            text-white
            bg-gray-950
            hover:bg-gray-800
            rounded-lg
            transition
            shadow
            focus:outline-none
            focus:ring-2
            focus:ring-gray-800
            focus:ring-offset-2
            focus:ring-offset-gray-100
        "
    >
    
        <span wire:loading.remove {{-- wire:target="save" --}}>
            
            {{ $name ?? "Save Data" }}

        </span>
     
        <span wire:loading wire:target="save" class="flex items-center gap-2">

            Processing Data...

        </span>
    
    </button>

</div>