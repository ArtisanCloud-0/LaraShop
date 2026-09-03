<div
    x-data="{
        init() {
            @if (session()->has('status'))
                $nextTick(() => {
                    $store.toasts.add({ message: '{{
        session('status')
    }}', type: 'success' });
                });
            @endif
            @if (session()->has('error'))
                $nextTick(() => {
                    $store.toasts.add({ message: '{{
        session('error')
    }}', type: 'error' });
                });
            @endif
        }
    }"
    class="fixed top-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none px-4"
>
    <template x-for="toast in $store.toasts.items" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-2 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            :class="{
                'bg-emerald-900/90 text-emerald-100 border-emerald-700': toast.type === 'success',
                'bg-rose-900/90 text-rose-100 border-rose-700': toast.type === 'error',
                'bg-amber-900/90 text-amber-100 border-amber-700': toast.type === 'warning',
                'bg-indigo-900/90 text-indigo-100 border-indigo-700': toast.type === 'info'
            }"
            class="pointer-events-auto flex items-start justify-between p-4 rounded-xl border shadow-xl backdrop-blur-md transition-all duration-200"
        >
            <div class="flex items-center gap-3">
                <template x-if="toast.type === 'success'">
                    <svg
                        class="w-5 h-5 text-emerald-400 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg
                        class="w-5 h-5 text-rose-400 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg
                        class="w-5 h-5 text-amber-400 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                        />
                    </svg>
                </template>

                <p
                    class="text-xs font-semibold leading-relaxed"
                    x-text="toast.message"
                ></p>
            </div>

            <button
                @click="$store.toasts.remove(toast.id)"
                class="ml-4 text-slate-400 hover:text-white transition"
            >
                &times;
            </button>
        </div>
    </template>
</div>
