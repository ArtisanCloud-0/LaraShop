@props(['target' => 'save', 'type' => 'submit', 'name' => 'Save Data'])
<div>
  <button
    type="{{ $type }}"
    class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-400 rounded-lg transition shadow focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 focus:ring-offset-gray-100"
  >
    <span wire:loading.remove wire:target="{{ $target }}">
      {{ $name }}
    </span>

    <span
      wire:loading
      wire:target="{{ $target }}"
      class="flex items-center gap-2"
    >
      Processing Data...
    </span>
  </button>
</div>
