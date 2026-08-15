<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-700 dark:text-white">Your Profile</h1>
        <p class="text-xs text-slate-500 dark:text-slate-400">Manage your account credentials and personal details.</p>
    </div>

    <x-message.session></x-message.session>

    <form wire:submit.prevent="save" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/60 rounded-2xl p-6 shadow-xl space-y-6">
        <!-- Avatar Preview Header -->
        <div class="flex items-center gap-4 pb-6 border-b border-slate-700/50">
            <img 
                src="https://ui-avatars.com/api/?name={{ urlencode($name ?: 'Admin') }}&background=6366f1&color=fff&size=128" 
                class="w-16 h-16 rounded-2xl border-2 border-indigo-500 shadow-md"
                alt="Avatar"
            >
            <div>
                <h3 class="text-sm font-semibold text-slate-600 dark:text-white">{{ $name ?: 'Admin User' }}</h3>
                <p class="text-xs text-slate-500/80 dark:text-slate-400">{{ $email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">Full Name</label>
                <input 
                    type="text" 
                    wire:model="name"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs text-slate-500 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    placeholder="John Doe"
                >
                @error('name') <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">Email Address</label>
                <input 
                    type="email" 
                    wire:model="email"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs text-slate-500 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    placeholder="admin@larashop.test"
                >
                @error('email') <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- New Password -->
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">New Password <span class="text-slate-500 font-normal">(Leave blank to keep current)</span></label>
                <input 
                    type="password" 
                    wire:model="password"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl px-4 py-2.5 text-xs text-slate-500 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    placeholder="••••••••"
                >
                @error('password') <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Action Button -->
        <div class="flex justify-end pt-4 border-t border-slate-700/50">
            <button 
                type="submit" 
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition duration-150 shadow-lg shadow-indigo-600/20"
            >
                Save Changes
            </button>
        </div>
    </form>
</div>
