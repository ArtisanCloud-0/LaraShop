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
                    leading-relaxed

                    text-emerald-900
                    bg-emerald-200/50
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
                        w-6
                        h-6
                        rounded-lg
                        leading-relaxed
                        text-emerald-600
                        hover:text-emerald-800
                        transition-colors
                        cursor-pointer
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
                leading-relaxed

                text-red-700
                bg-red-200/50
                border-red-200
                
                dark:text-red-400
                dark:bg-red-950/50
                dark:border-red-800
            "
        >
    
            <div class="flex justify-between">
                
                <p>
                    {{ session('error') }}
                </p>

                <button 
                    class="
                        w-6
                        h-6
                        rounded-lg
                        leading-relaxed
                        text-red-600
                        hover:text-red-800
                        transition-colors
                        cursor-pointer
                    "
                    x-on:click="show = !show"
                >
                    X
                </button>

            </div>
    
        </div>
    
    @endif

</div>