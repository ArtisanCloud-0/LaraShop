<div class="min-h-screen bg-slate-50 dark:bg-slate-950 flex flex-col justify-center items-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">

        {{-- Login Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-2xl">
        
        {{-- Brand Header --}}
        <div class="text-center border-b border-slate-300/50 dark:border-slate-400/50 pb-5 mb-10">
            <div class="inline-flex items-center gap-x-2">
                <span class="text-3xl font-black tracking-tight text-slate-800 dark:text-white">
                    LaraShop<span class="text-blue-800 dark:text-blue-500">.</span>
                </span>
                <span class="px-2 py-0.5 text-[10px] font-mono font-bold tracking-widest text-blue-500 dark:text-blue-400 bg-blue-500/10 border border-blue-500/20 rounded uppercase">
                    Admin
                </span>
            </div>
            <h2 class="mt-4 text-xl font-bold text-slate-500 dark:text-slate-200">
                Control Panel Access
            </h2>
            <p class="mt-1 text-xs text-slate-500/80 dark:text-slate-400">
                Sign in with your administrative credentials
            </p>
        </div>

            <form wire:submit="authenticate" class="space-y-5">
                
                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-300 mb-2">
                        Email Address
                    </label>
                    <input 
                        wire:model="email" 
                        type="email" 
                        id="email" 
                        required 
                        autofocus
                        placeholder="admin@larashop.com"
                        class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl text-sm text-slate-500 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition"
                    >
                    @error('email') 
                        <span class="text-xs text-red-500 dark:text-red-400 mt-1.5 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-300 mb-2">
                        Password
                    </label>
                    <input 
                        wire:model="password" 
                        type="password" 
                        id="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 rounded-xl text-sm text-slate-500 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition"
                    >
                    @error('password') 
                        <span class="text-xs text-red-500 dark:text-red-400 mt-1.5 block font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input 
                            wire:model="remember" 
                            type="checkbox" 
                            class="w-4 h-4 rounded bg-slate-950 border-slate-800 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-900"
                        >
                        <span class="text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-300 transition">Remember me</span>
                    </label>

                    <a href="#" class="text-blue-500 dark:text-blue-400 hover:text-blue-400 dark:hover:text-blue-300 font-semibold transition">
                        Forgot password?
                    </a>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-blue-600/20 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="authenticate">Sign In to Dashboard</span>
                    <span wire:loading wire:target="authenticate" class="flex items-center flex-row gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Authenticating
                    </span>
                </button>

            </form>
        </div>

    </div>
</div>