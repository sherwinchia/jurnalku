@if (strtolower($type) == 'success' || strtolower($type) == 'win')
  <span
    class="px-3 py-1 text-sm font-normal text-green-500 bg-green-100 rounded-full dark:bg-green-400 dark:text-green-100">
    {{ $slot }}
  </span>
@elseif(strtolower($type) == "pending" || strtolower($type) == "open")
  <span
    class="px-3 py-1 text-sm font-normal text-yellow-500 bg-yellow-100 rounded-full dark:bg-yellow-400 dark:text-yellow-100">
    {{ $slot }}
  </span>
@elseif(strtolower($type) == "fail" || strtolower($type) == "lose")
  <span class="px-3 py-1 text-sm font-normal text-red-500 bg-red-100 rounded-full dark:bg-red-400 dark:text-red-100">
    {{ $slot }}
  </span>
@else
  <span class="px-3 py-1 text-sm font-normal text-gray-500 bg-gray-100 rounded-full dark:bg-gray-400 dark:text-gray-100">
    {{ $slot }}
  </span>
@endif
