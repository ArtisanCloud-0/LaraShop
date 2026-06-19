<div>

    <x-table.pagination
        title="Category"
        note="From here you will be able to create, update, and delete Categories details"
        :paginate="$categories"
        :columns="['Category Details', 'Slug Index', 'Structural Placement Tree Type', 'Attached Products']"
    >
        <x-slot:data>
            @forelse($categories as $cat)
                        <tr class="hover:bg-slate-900/30 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-200">{{ $cat->name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    Status Flag: {{ $cat->is_visible ? '🟢 Public View' : '🔴 Internal Sandbox Only' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-400">{{ $cat->slug }}</td>
                            <td class="px-6 py-4">
                                @if($cat->parent)
                                    <span class="px-2 py-1 text-xs font-semibold bg-slate-800 text-indigo-400 rounded">Sub of {{ $cat->parent->name }}</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-indigo-950 text-indigo-300 rounded">Root Level Node</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-slate-400">{{ $cat->products_count }} items</td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="deleteCategory({{ $cat->id }})" 
                                        wire:confirm="Are you completely sure you want to run this destructive action execution parameter cascade sync drop?"
                                        class="text-xs font-semibold text-red-400 hover:text-red-300 transition bg-red-950/20 hover:bg-red-950/50 border border-red-900/40 px-3 py-1.5 rounded-md">
                                    Delete Record
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-800 dark:text-slate-500 font-medium">
                                No functional system data records mapping items found inside database layer yet.
                            </td>
                        </tr>
                    @endforelse
        </x-slot:data>
    </x-table.pagination>

</div>
