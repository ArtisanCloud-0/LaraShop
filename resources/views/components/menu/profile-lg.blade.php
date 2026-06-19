@props(['links' => []])
<el-dropdown class="relative ml-3">   

    <button class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
        <span class="absolute -inset-1.5"></span>
        <span class="sr-only">Open user menu</span>
        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full outline -outline-offset-1 outline-white/10" />
    </button>

    <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
        @foreach($links as $link)
            <a
                href="#"
                class="
                    block
                    px-4
                    py-2
                    text-sm
                    text-gray-700
                    focus:bg-gray-100
                    focus:outline-hidden 
                    dark:text-gray-300 
                    dark:focus:bg-white/5
                "
            >
                {{ $link['name'] }}
            </a>
        @endforeach
    </el-menu>
    
</el-dropdown>
