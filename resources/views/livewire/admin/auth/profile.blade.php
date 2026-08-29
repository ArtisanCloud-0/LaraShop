<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-700 dark:text-white">Your Profile</h1>
        <p class="text-xs text-slate-500 dark:text-slate-400">Manage your account credentials and personal details.</p>
    </div>

    <x-message.session></x-message.session>

    <form wire:submit.prevent="save" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/60 rounded-2xl p-6 shadow-xl space-y-6">
        
        <!-- Avatar Preview Header & Upload Input -->
        <div class="flex items-center gap-6 pb-6 border-b border-slate-700/50">
            <div class="relative">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-indigo-500 shadow-md">
                @else
                    <img 
                        src="{{ auth('panel')->user()->image ? asset('storage/profiles/' . auth('panel')->user()->image) : asset('PNG/avatar.png') }}" 
                        class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-200 dark:border-slate-600 shadow-md"
                        alt="Avatar"
                    >
                @endif

                <div wire:loading wire:target="image" class="absolute inset-0 px-1.5 py-4 bg-slate-900/90 rounded-2xl flex items-center justify-center text-white text-[10px]">
                    Uploading...
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-600 dark:text-white">{{ $name ?: 'Admin User' }}</h3>
                <p class="text-xs text-slate-500/80 dark:text-slate-400 mb-2">{{ $email }}</p>
                
                <label class="cursor-pointer text-xs font-bold text-orange-500 dark:text-orange-300 hover:text-orange-400 border border-orange-500/30 px-3 py-1.5 rounded-xl bg-orange-50 dark:bg-orange-950/40 inline-block transition">
                    <span>Change Photo</span>
                    <input 
                        type="file" 
                        wire:model="image" 
                        id="profile-image-input" 
                        class="hidden" 
                        accept="image/png, image/jpeg, image/jpg, image/webp"
                    >
                </label>
                @error('image') <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
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
                class="px-5 py-2.5 bg-orange-500 hover:bg-orange-400 text-white text-xs font-semibold rounded-xl transition duration-150 shadow-lg shadow-orange-600/20"
            >
                Save Changes
            </button>
        </div>
    </form>
</div>