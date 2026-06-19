@props(['links' => []])
<div>
    <div class="hidden md:block">
        <div class="ml-10 flex items-baseline space-x-4">
            @foreach($links as $link)
                <a
                    href="{{ route($link['route']) }}" 
                    @if(Route::currentRouteName() === $link['route']) 
                        aria-current="page"  
                        class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white dark:bg-gray-950/50"
                    @else
                        class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-200/55 hover:text-gray-700 dark:hover:bg-white/5 dark:hover:text-white dark:text-gray-300"
                    @endif  
                >
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>