<div>
    <div class="space-y-12 mb-10">
        {{-- Hero Banner Grid --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Main Hero (Spans 2 columns on large screens) --}}
            <div
                class="relative overflow-hidden rounded-3xl bg-linear-to-br from-slate-100 via-slate-50 to-slate-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-8 dark:text-white shadow-2xl lg:col-span-2 lg:p-12 flex flex-col justify-between min-h-95"
            >
                {{-- Decorative Gradient Background Blur --}}
                <div
                    class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-orange-500/20 blur-3xl"
                ></div>
                <div
                    class="absolute -left-20 -bottom-20 h-72 w-72 rounded-full bg-amber-500/10 blur-3xl"
                ></div>

                <div class="relative z-10 max-w-xl space-y-4">
                    <h1
                        class="text-3xl font-extrabold tracking-tight sm:text-5xl"
                    >
                        Discover Quality Products, Crafted for You<span
                            class="text-orange-500"
                            >.</span
                        >
                    </h1>
                    <p
                        class="text-sm text-slate-600 dark:text-slate-300 sm:text-base"
                    >
                        Explore our curated collection of top-rated items with
                        exclusive discounts and fast doorstep delivery.
                    </p>
                </div>

                <div
                    class="relative z-10 pt-6 flex flex-wrap items-center gap-4"
                >
                    <a
                        href="{{ route('products') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-orange-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-600/30 transition hover:bg-orange-500 focus:outline-none"
                    >
                        <span>Shop All Collection</span>
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                        </svg>
                    </a>
                    <a
                        href="{{ route('products', ['featured' => 1]) }}"
                        class="rounded-xl border border-slate-400 bg-slate-100 text-slate-600 dark:border-slate-400 dark:bg-slate-800/50 px-6 py-3 text-sm font-semibold dark:text-slate-200 backdrop-blur transition hover:bg-slate-800 hover:text-white dark:hover:bg-slate-800 dark:hover:text-white"
                    >
                        View Featured
                    </a>
                </div>
            </div>

            {{-- Side Callout Cards --}}
            <div class="flex flex-col gap-6">
                {{-- Hot Deal Card --}}
                <div
                    class="relative flex-1 overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 flex flex-col justify-between"
                >
                    <div class="space-y-2">
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-orange-500"
                            >Limited Offer</span
                        >
                        <h3
                            class="text-xl font-bold text-slate-900 dark:text-slate-100"
                        >
                            Special Weekly Discounts
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Save up to 40% on select items this week only.
                        </p>
                    </div>
                    <div class="pt-4">
                        <a
                            href="{{ route('products') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-orange-600 hover:text-orange-500 dark:text-orange-400"
                        >
                            <span>Browse Deals</span>
                            <svg
                                class="w-3.5 h-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Support & Quality Card --}}
                <div
                    class="relative flex-1 overflow-hidden rounded-3xl border border-slate-200 bg-linear-to-br from-orange-500 to-amber-600 p-6 text-white shadow-sm flex flex-col justify-between"
                >
                    <div class="space-y-2">
                        <span
                            class="text-[11px] font-bold uppercase tracking-wider text-orange-100"
                            >Why LaraShop?</span
                        >
                        <h3 class="text-xl font-bold">
                            Fast Delivery & Verified Quality
                        </h3>
                        <p class="text-xs text-orange-100/90">
                            Guaranteed authentic items backed by direct customer
                            support.
                        </p>
                    </div>
                    <div class="pt-4">
                        <span
                            class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-3 py-1.5 text-xs font-medium backdrop-blur"
                        >
                            <svg
                                class="w-4 h-4 text-orange-200"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            100% Secure Checkout
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📦 PRIMARY PRODUCT SHOWCASE GRID -->
    <div id="catalog" class="scroll-mt-20">
        <div
            class="flex items-center justify-between pb-4 mb-6 border-b border-slate-200 dark:border-slate-800"
        >
            <div>
                <h3
                    class="text-lg font-black text-slate-900 dark:text-slate-100"
                >
                    Featured Trends & Essentials
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">
                    Select a variant size or color right from the product layout
                    card.
                </p>
            </div>

            <!-- Structural Counter Anchor using Eye SVG -->
            <span
                class="inline-flex items-center gap-x-1.5 text-xs text-slate-400 font-medium"
            >
                <svg
                    class="w-4 h-4 text-blue-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>
                Showing 8 New Styles
            </span>
        </div>

        <!-- Product Cards Grid Loop Layout -->
        <x-card.products :products="$products"></x-card.products>
    </div>
</div>
