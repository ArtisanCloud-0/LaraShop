<div
    x-data="{
        show: true
    }"
>

    @if (session()->has('status'))
    
        <div
            x-show="show" 
            x-transition
            class=
                "
                    mb-4
                    p-4
                    border
                    text-sm
                    font-bold
                    rounded-lg

                    text-emerald-900
                    bg-emerald-300
                    border-emerald-200
                    
                    dark:text-emerald-400
                    dark:bg-emerald-950/50
                    dark:border-emerald-800
                "
        >
    
            <div class="flex justify-between">
                
                <p>
                    {{ session('status') }}
                </p>

                <button 
                    class="
                        px-4
                        py-1
                        mx-0
                        my-0
                        rounded-full
                        bg-emerald-50
                        hover:bg-emerald-100
                    "
                    x-on:click="show = !show"
                >
                    X
                </button>

            </div>
    
        </div>
    
    @endif

    @if (session()->has('error'))
    
        <div 
            x-show="show" 
            x-transition
            class="
                p-4
                mb-4
                border
                text-sm
                font-bold
                rounded-lg

                text-red-800
                bg-red-300
                border-red-200
                
                dark:text-red-400
                dark:bg-red-950/50
                dark:border-red-800
            "
        >
    
            <div class="flex justify-between">
                
                <p>
                    {{ session('status') }}
                </p>

                <button 
                    class="
                        px-4
                        py-1
                        mx-0
                        my-0
                        bg-red-50
                        rounded-full
                        hover:bg-red-100
                    "
                    x-on:click="show = !show"
                >
                    X
                </button>

            </div>
    
        </div>
    
    @endif

</div>