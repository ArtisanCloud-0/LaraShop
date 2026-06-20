<div>

    <div class="max-w-6xl mx-auto my-8 p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-md text-gray-700 dark:text-slate-100 dark:border-slate-800 dark:bg-slate-900">
        
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-300 dark:border-slate-800">
            <div>
                <h2 class="text-xl font-semibold tracking-tight">System Collections {{ $title }} Registry</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 font-mono">{{ $note }}</p>
            </div>
            <a href="{{ route('panel.categories.create') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-950 hover:bg-gray-800 rounded-lg transition shadow focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 focus:ring-offset-gray-100">
                + Add New {{ $title }}
            </a>
        </div>
    
        {{-- Session Messages --}}
        <x-message.session></x-message.session>

        <div class="overflow-x-auto rounded-lg border border-slate-200/50 bg-gray-200/50 dark:bg-slate-950 dark:border-slate-800">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200/50 bg-gray-200 text-xs font-semibold text-gray-700 uppercase tracking-wider dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                        @foreach($columns as $col)
                        <th class="px-6 py-4">{{ $col }}</th>
                        {{-- <th class="px-6 py-4">Slug Index</th>
                        <th class="px-6 py-4">Structural Placement Tree Type</th>
                        <th class="px-6 py-4 text-center">Attached Products</th> --}}
                        @endforeach
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 text-sm font-medium text-gray-500 dark:text-slate-300 dark:divide-slate-800">
                    {{ $data }}
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $paginate->links() }}
        </div>

    </div>

</div>