@props(['products'])

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

    @foreach ($products as $index => $product)

        @php
            /*
             * Get the first available variant.
             */
            $firstVariant = $product->productDetails->first();

            /*
             * Product prices are stored in the smallest currency unit.
             * Convert to the display amount here.
             */
            $formattedPrice = $firstVariant
                ? number_format($firstVariant->price / 100, 2)
                : '0.00';

            /*
             * The image can be:
             *
             * 1. A full URL:
             *    https://placehold.co/800x800/png?text=LaraShop
             *
             * 2. A Laravel storage path:
             *    products/example.jpg
             *
             * Support both.
             */
            $imageUrl = null;

            if ($product->primary_image) {
                $imageUrl = filter_var(
                    $product->primary_image,
                    FILTER_VALIDATE_URL
                )
                    ? $product->primary_image
                    : Storage::url($product->primary_image);
            }
        @endphp

        <div
            x-data="{
                showVariants: false,
                selectedVariantId: '{{ $firstVariant?->id }}'
            }"
            @mouseleave="showVariants = false"
            class="group relative flex flex-col justify-between rounded-xl border border-slate-200 bg-white p-4 transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900"
        >

            <!-- Product Media -->
            <div
                class="relative aspect-square w-full overflow-hidden rounded-lg border border-slate-200 bg-slate-100 dark:border-slate-800 dark:bg-slate-950"
            >

                @if ($imageUrl)

                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $product->name }}"
                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                        loading="lazy"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >

                    <!-- Image error fallback -->
                    <div
                        class="absolute inset-0 hidden flex-col items-center justify-center p-4 text-center font-mono text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-600"
                    >
                        <svg
                            class="mb-2 h-8 w-8 text-slate-300 dark:text-slate-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                            />
                        </svg>

                        <span>Image unavailable</span>
                    </div>

                @else

                    <!-- No image fallback -->
                    <div
                        class="flex h-full w-full flex-col items-center justify-center p-4 text-center font-mono text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-600"
                    >
                        <svg
                            class="mb-2 h-8 w-8 text-slate-300 dark:text-slate-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 1 1-.75 0 .375 0 0 1 .75 0Z"
                            />
                        </svg>

                        <span>No image</span>
                    </div>

                @endif


                <!-- Variant Selection -->
                <div
                    x-show="showVariants"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="scale-95 opacity-0"
                    x-transition:enter-end="scale-100 opacity-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="scale-100 opacity-100"
                    x-transition:leave-end="scale-95 opacity-0"
                    class="absolute inset-0 z-10 flex flex-col justify-between bg-slate-50/95 p-3 backdrop-blur-sm dark:bg-slate-950/95"
                    style="display: none;"
                >

                    <!-- Variant header -->
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2 dark:border-slate-700/50">

                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Select Variant
                        </span>

                        <button
                            @click="showVariants = false"
                            type="button"
                            class="text-xs text-slate-400 transition hover:text-slate-900 dark:hover:text-white"
                            aria-label="Close variant selector"
                        >
                            ✕
                        </button>

                    </div>


                    <!-- Variant options -->
                    <div class="my-auto max-h-36 space-y-1.5 overflow-y-auto pr-1">

                        @forelse ($product->productDetails as $variant)

                            @php
                                $label = is_array($variant->options)
                                    ? implode(' / ', $variant->options)
                                    : ($variant->code ?? 'Option');
                            @endphp

                            <button
                                type="button"
                                @click="selectedVariantId = '{{ $variant->id }}'"
                                :class="
                                    selectedVariantId == '{{ $variant->id }}'
                                        ? 'bg-blue-600 text-white border-blue-500'
                                        : 'bg-slate-100 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300 border-slate-300 dark:border-slate-700 hover:border-slate-500'
                                "
                                class="flex w-full items-center justify-between rounded-md border px-2.5 py-1.5 text-left text-xs font-mono transition"
                            >

                                <span class="truncate">
                                    {{ $label }}
                                </span>

                                <span class="ml-2 shrink-0 font-bold">
                                    ${{ number_format($variant->price / 100, 2) }}
                                </span>

                            </button>

                        @empty

                            <div class="py-4 text-center text-xs text-slate-400">
                                No variants available.
                            </div>

                        @endforelse

                    </div>


                    <!-- Confirm -->
                    <button
                        type="button"
                        @click="$wire.addToCart(selectedVariantId); showVariants = false"
                        :disabled="!selectedVariantId"
                        class="w-full rounded-md bg-blue-600 py-1.5 text-xs font-bold uppercase tracking-wider text-white transition hover:bg-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Confirm Add
                    </button>

                </div>


                <!-- Quick View Overlay -->
                <div
                    x-show="!showVariants"
                    class="absolute inset-0 flex items-center justify-center bg-slate-950/40 opacity-0 transition duration-200 group-hover:opacity-100"
                >

                    <a
                        href="{{ route('product.details', $product->slug) }}"
                        class="rounded-lg bg-white p-2.5 text-slate-700 shadow transition hover:text-blue-600 dark:bg-slate-900 dark:text-slate-300 dark:hover:text-blue-400"
                        title="Quick Product Preview"
                        aria-label="View {{ $product->name }}"
                    >

                        <svg
                            class="h-4 w-4"
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

                    </a>

                </div>

            </div>


            <!-- Product Information -->
            <div class="mt-4 flex-1">

                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    {{ $product->category?->name ?? 'Uncategorized' }}
                </span>

                <h4 class="mt-0.5 line-clamp-1 text-sm font-bold text-slate-900 dark:text-slate-100">

                    <a
                        href="{{ route('product.details', $product->slug) }}"
                        class="transition hover:text-blue-600 dark:hover:text-blue-400"
                    >
                        {{ $product->name }}
                    </a>

                </h4>

            </div>


            <!-- Product Footer -->
            <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 dark:border-slate-800">

                <span class="text-sm font-black text-slate-900 dark:text-white">
                    ${{ $formattedPrice }}
                </span>

                <button
                    type="button"
                    @click="showVariants = !showVariants"
                    @if (!$firstVariant)
                        disabled
                    @endif
                    class="inline-flex items-center gap-x-1.5 rounded-md bg-slate-800 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-500 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-slate-800 dark:hover:bg-blue-600"
                >

                    <svg
                        class="h-3 w-3"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15"
                        />
                    </svg>

                    <span>
                        {{ $firstVariant ? 'Add to Bag' : 'Unavailable' }}
                    </span>

                </button>

            </div>

        </div>

    @endforeach

</div>
