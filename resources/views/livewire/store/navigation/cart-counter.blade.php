<div>
    <a href="{{ route('cart') }}" class="group flex items-center p-2 text-orange-400 dark:text-orange-300 hover:text-orange-500 dark:hover:text-orange-200">
        <div class="relative">
            <svg class="h-6 w-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
            </svg>

            {{-- Optional indicator badge if count > 0 --}}
            @if($count > 0)
                <span class="absolute -top-1 -right-1 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
            @endif
        </div>

        {{-- Dynamic Count --}}
        <span class=
            "
                ml-2 
                text-sm 
                font-medium 
                text-orange-400 
                dark:text-orange-300 
                group-hover:text-orange-500 
                dark:group-hover:text-orange-200
            "
        >
            {{ $count }}
        </span>
    </a>
</div>
