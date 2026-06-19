@props(['links' => []])
<div>
    <div class="border-t border-gray-200 dark:border-white/10 pt-4 pb-3 mx-5">
        
        <div class="flex items-center px-5">
            
            <div class="shrink-0">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full outline -outline-offset-1 outline-white/10" />
            </div>

            <div class="ml-3">
                <div class="text-base/5 font-medium text-gray-700 dark:text-white">Tom Cook</div>
                <div class="text-sm font-medium text-gray-400 dark:text-gray-200">tom@example.com</div>
            </div>

            <button 
                type="button" 
                class="
                    relative 
                    ml-auto 
                    shrink-0 
                    rounded-full 
                    p-1 
                    text-gray-400 
                    hover:text-gray-500 
                    focus:outline-2 
                    focus:outline-offset-2 
                    focus:outline-gray-200
                    dark:text-gray-400 
                    dark:hover:text-white
                "
            >
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">View notifications</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                    <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

        </div>

        <div class="mt-3 space-y-1 px-2">
            @foreach($links as $link)
                <a 
                    href="#" 
                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-200/50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                >
                    {{ $link['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>