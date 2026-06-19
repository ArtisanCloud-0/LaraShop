<div>
    @if (session()->has('status'))
        <div class="mb-4 p-4 bg-emerald-950/50 border border-emerald-800 text-emerald-400 text-sm rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-950/50 border border-red-800 text-red-400 text-sm rounded-lg">
            {{ session('error') }}
        </div>
    @endif
</div>