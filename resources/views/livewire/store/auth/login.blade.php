<div
  class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-300/50 dark:border-slate-700 shadow px-6 py-3 w-full md:w-2xl mx-auto"
>
  <div class="flex justify-center mb-5">
    <img class="max-w-80" src="{{ asset('PNG/Artboard 1.png') }}" alt="" />
  </div>

  <form wire:submit.prevent="login">
    <!-- Email -->
    <div class="mb-8">
      <x-form.input
        for="email"
        type="email"
        placeholder="Enter Email"
      ></x-form.input>
    </div>

    <!-- Password -->
    <div class="mb-5">
      <x-form.input
        for="password"
        type="password"
        placeholder="Enter Password"
      ></x-form.input>
    </div>

    <div class="block sm:flex sm:justify-between mb-3">
      <div class="flex justify-between align-middle mb-5 md:mb-0 md:space-x-15">
        <p class="pt-1">
          <a
            class="text-orange-400 hover:text-orange-500 dark:text-orange-300 dark:hover:text-orange-400"
            href="{{ route('reset.password') }}"
          >
            Forget Password?
          </a>
        </p>
        <p class="pt-1">
          Do not have account
          <a
            class="text-orange-400 hover:text-orange-500 dark:text-orange-300 dark:hover:text-orange-400"
            href="{{ route('register') }}"
            >Create New</a
          >
        </p>
      </div>
      <x-button.execute
        name="Start your session"
        target="login"
      ></x-button.execute>
    </div>
  </form>
</div>
