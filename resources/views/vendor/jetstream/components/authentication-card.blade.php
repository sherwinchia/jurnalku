<div class="flex flex-col items-center flex-1 h-full min-h-screen pt-6 sm:justify-center sm:pt-0">
  <div>
    <a href="{{ route('user.home.index') }}">{{ $logo }}</a>
  </div>

  <div class="w-full px-6 py-4 mt-6 overflow-hidden shadow-md lg:w-96 sm:rounded-lg">
    {{ $slot }}
  </div>
</div>
