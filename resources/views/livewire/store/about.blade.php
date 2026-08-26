<div class="space-y-16 py-4 sm:py-8">
  {{-- Hero Section --}}
  <section class="text-center space-y-4 max-w-3xl mx-auto">
    <span
      class="inline-block rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-600 dark:bg-orange-950/60 dark:text-orange-400"
    >
      Our Performance
    </span>
    <h1
      class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 sm:text-5xl"
    >
      Redefining your online shopping experience<span class="text-orange-500"
        >.</span
      >
    </h1>
    <p class="text-base text-slate-600 dark:text-slate-400 sm:text-lg">
      At LaraShop, we bridge quality products with modern web technology to
      deliver a seamless, fast, and reliable marketplace built for everyone.
    </p>
  </section>

  {{-- Dynamic Percentage Stats Grid --}}
  <section class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:gap-6">
    <div
      class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm dark:border-slate-800 dark:bg-slate-900"
    >
      <p class="text-3xl font-extrabold text-orange-600 dark:text-orange-400">
        {{ $productAvailabilityRate }}%
      </p>
      <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">
        Catalog In-Stock Rate
      </p>
    </div>

    <div
      class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm dark:border-slate-800 dark:bg-slate-900"
    >
      <p class="text-3xl font-extrabold text-orange-600 dark:text-orange-400">
        {{ $orderFulfillmentRate }}%
      </p>
      <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">
        Order Success Rate
      </p>
    </div>

    <div
      class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm dark:border-slate-800 dark:bg-slate-900"
    >
      <p class="text-3xl font-extrabold text-orange-600 dark:text-orange-400">
        {{ $customerSatisfactionRate }}%
      </p>
      <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">
        Customer Retention
      </p>
    </div>

    <div
      class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm dark:border-slate-800 dark:bg-slate-900"
    >
      <p class="text-3xl font-extrabold text-orange-600 dark:text-orange-400">
        {{ $platformUptime }}%
      </p>
      <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">
        Platform Reliability
      </p>
    </div>
  </section>

  {{-- Values Section --}}
  <section class="space-y-8">
    <div class="text-center space-y-2">
      <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
        Why Shop With Us?
      </h2>
      <p class="text-sm text-slate-500 dark:text-slate-400">
        Built around core values that put the customer first.
      </p>
    </div>

    <div class="grid gap-6 sm:grid-cols-3">
      <div
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-3"
      >
        <div
          class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600 dark:bg-orange-950/50 dark:text-orange-400"
        >
          <svg
            class="h-5 w-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13 10V3L4 14h7v7l9-11h-7z"
            />
          </svg>
        </div>
        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-200">
          Lightning Fast
        </h3>
        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
          Optimized database queries and modern reactive interfaces guarantee
          swift browsing and instant checkouts.
        </p>
      </div>

      <div
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-3"
      >
        <div
          class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600 dark:bg-orange-950/50 dark:text-orange-400"
        >
          <svg
            class="h-5 w-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
            />
          </svg>
        </div>
        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-200">
          Secure Transactions
        </h3>
        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
          All orders are processed with strict data integrity standards and
          transactional safety algorithms.
        </p>
      </div>

      <div
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-3"
      >
        <div
          class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600 dark:bg-orange-950/50 dark:text-orange-400"
        >
          <svg
            class="h-5 w-5"
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
        </div>
        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-200">
          Curated Quality
        </h3>
        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
          Every single item listed in our store undergoes strict dynamic review
          processes before going live.
        </p>
      </div>
    </div>
  </section>

  {{-- Call to Action --}}
  <section
    class="rounded-3xl bg-slate-900 p-8 text-center text-white dark:bg-slate-900/60 dark:border dark:border-slate-800 sm:p-12 space-y-6"
  >
    <h2 class="text-2xl font-bold sm:text-3xl">
      Ready to discover exceptional items?
    </h2>
    <p class="text-sm text-slate-300 max-w-xl mx-auto">
      Explore our broad catalog of items spanning across our diverse categories
      today.
    </p>
    <div>
      <a
        href="{{ route('products') }}"
        class="inline-flex items-center justify-center rounded-xl bg-orange-600 px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-orange-500 transition-colors"
      >
        Start Shopping
      </a>
    </div>
  </section>
</div>
