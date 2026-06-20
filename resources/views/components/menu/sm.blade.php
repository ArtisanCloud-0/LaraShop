@props(['links' => []])
<div>
    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
        @foreach($links as $link)
            <a 
                href="{{ route($link['route']) }}"
                @if(request()->routeIs($link['pattern'])) 
                    aria-current="page" 
                    class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white dark:bg-gray-950/50"
                @else
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-500 hover:bg-gray-200/50 hover:text-gray-700 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
                @endif
            >
                {{ $link['name'] }}
            </a>
        @endforeach
    </div>
</div>