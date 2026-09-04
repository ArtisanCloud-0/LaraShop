<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-100">
            Account Profile
        </h1>
        <p class="text-sm text-slate-500 dark:text-slate-400">
            Manage your personal details and account settings.
        </p>
    </div>

    <!-- Personal Info Card -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-6">
        <h2 class="text-base font-bold text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-800 pb-3">
            Profile Information
        </h2>

        <form wire:submit="updateProfile" class="space-y-6">
            <!-- Profile Image Picker -->
            <div class="flex flex-col sm:flex-row items-center gap-5">
                <div class="relative shrink-0">
                    @if($new_image)
                        <img src="{{ $new_image->temporaryUrl() }}" class="h-20 w-20 rounded-full object-cover border-2 border-orange-500 shadow-sm" />
                    @elseif($user->image)
                        <img src="{{ Storage::url($user->image) }}" class="h-20 w-20 rounded-full object-cover border-2 border-slate-200 dark:border-slate-700 shadow-sm" />
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-orange-500 text-2xl font-bold text-white shadow-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <div wire:loading wire:target="new_image" class="absolute inset-0 flex items-center justify-center rounded-full bg-slate-900/60 text-white">
                        <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <div class="space-y-2 text-center sm:text-left">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <label class="cursor-pointer inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 transition">
                            <span>Upload New Photo</span>
                            <input type="file" wire:model="new_image" accept="image/*" class="hidden" />
                        </label>

                        @if($user->image)
                            <button type="button" wire:click="removeImage" wire:confirm="Are you sure you want to remove your photo?" class="text-xs font-semibold text-rose-500 hover:underline px-2 py-1.5">
                                Remove
                            </button>
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-400">JPG, PNG, or WEBP up to 2MB.</p>
                    @error('new_image') <span class="text-xs text-rose-500 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Full Name</label>
                    <input type="text" wire:model="name" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-800 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition" />
                    @error('name') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Email Address</label>
                    <input type="email" wire:model="email" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-800 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition" />
                    @error('email') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Phone Number</label>
                    <input type="text" wire:model="phone" placeholder="+1 (555) 000-0000" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-800 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition" />
                    @error('phone') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled" class="rounded-xl bg-orange-600 px-5 py-2 text-xs font-bold text-white shadow-sm hover:bg-orange-500 transition inline-flex items-center gap-2">
                    <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                    <span wire:loading wire:target="updateProfile">Saving...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Security/Password Card -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-6">
        <h2 class="text-base font-bold text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-800 pb-3">
            Change Password
        </h2>

        <form wire:submit="updatePassword" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Current Password</label>
                <input type="password" wire:model="current_password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-800 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition" />
                @error('current_password') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">New Password</label>
                    <input type="password" wire:model="new_password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-800 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition" />
                    @error('new_password') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Confirm New Password</label>
                    <input type="password" wire:model="new_password_confirmation" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-800 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition" />
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled" class="rounded-xl border border-slate-200 bg-slate-100 px-5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 transition inline-flex items-center gap-2">
                    <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                    <span wire:loading wire:target="updatePassword">Updating...</span>
                </button>
            </div>
        </form>
    </div>
</div>