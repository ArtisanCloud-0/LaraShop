<div class="py-6 space-y-6">

    <x-message.session></x-message.session>
    
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Admin Users</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Manage administrative roles and system access.</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Search --}}
            <input 
                type="search" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search admins..." 
                class="rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-xs text-gray-900 dark:text-white px-3 py-2 w-full sm:w-64"
            >

            <!-- Create Button -->
            <button 
                wire:click="openCreateModal" 
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-colors shrink-0 shadow-sm"
            >
                + Add Admin
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/60 text-gray-400 uppercase tracking-wider font-semibold">
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Created At</th>
                        <th class="p-4">Last Update</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/40 text-gray-700 dark:text-gray-300">
                    @forelse($admins as $admin)
                        <tr>
                            <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $admin->name }}</td>
                            <td class="p-4">{{ $admin->email }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $admin->role === 'super_admin' ? 'bg-purple-500/10 text-purple-600 dark:text-purple-400' : 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' }}">
                                    {{ strtoupper(str_replace('_', ' ', $admin->role)) }}
                                </span>
                            </td>
                            <td class="p-4">{{ $admin->created_at->format('M d, Y') }}</td>
                            <td class="p-4">{{ $admin->updated_at->format('M d, Y') }}</td>
                            <td class="p-4 text-right space-x-2">
                                <button wire:click="openEditModal({{ $admin->id }})" class="font-bold text-indigo-600/90 dark:text-indigo-300 hover:underline">Edit</button>
                                @if($admin->id !== auth()->id())
                                    <button 
                                        wire:click="delete({{ $admin->id }})" 
                                        wire:confirm="Are you sure you want to delete this admin?" 
                                        class="font-bold text-red-500/90 dark:text-red-300 hover:underline"
                                    >
                                        Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">No admin users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100 dark:border-gray-700/60">
            {{ $admins->links() }}
        </div>
    </div>

    <!-- Modal Form (Alpine JS Powered) -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700 max-w-md w-full p-6 shadow-xl space-y-4">
                
                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                    {{ $editingUserId ? 'Edit Admin User' : 'Create Admin User' }}
                </h3>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-xs text-gray-900 dark:text-white p-2.5">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-xs text-gray-900 dark:text-white p-2.5">
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                            Password {{ $editingUserId ? '(Leave blank to keep existing)' : '' }}
                        </label>
                        <input type="password" wire:model="password" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-xs text-gray-900 dark:text-white p-2.5">
                        @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select wire:model="role" class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-xs text-gray-900 dark:text-white p-2.5">
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        @error('role') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 text-xs font-bold text-gray-500 hover:underline">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold">
                            {{ $editingUserId ? 'Update Admin' : 'Create Admin' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @endif

</div>