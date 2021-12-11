<x-layout.landing>
  <div style="min-height: 60vh" class="grid items-start w-full grid-cols-4 gap-4 py-8 mx-auto lg:gap-6 max-w-7xl">
    <x-ui.card class="flex flex-col p-6 m-4 space-y-4 lg:m-0 col-span-full lg:col-span-3">
      <div class="flex flex-col space-y-1">
        <x-ui.header class="text-2xl font-semibold">
          {{ $blog->title }}
        </x-ui.header>
        <div class="flex space-x-2">
          <span
            class="pr-2 border-r border-gray-700 dark:border-gray-400">{{ date_to_human($blog->published_at, 'd F Y') }}
          </span>
          <span>{{ $blog->read_minutes }}</span>
        </div>
      </div>
      <div class="prose">{!! $blog->body !!}</div>
    </x-ui.card>

    <div class="sticky flex flex-col m-4 space-y-4 col-span-full lg:col-span-1 top-4 lg:m-0">
      <x-ui.header class="pb-2 text-xl font-semibold border-b">More Blogs</x-ui.header>
      @foreach ($other_blogs as $blog)
        <a href="{{ route('user.blogs.show', $blog->slug) }}">
          <x-ui.card class="sticky flex flex-col p-4 space-y-4">
            <div class="flex flex-col space-y-1">
              <x-ui.header class="text-lg font-semibold">
                {{ $blog->title }}
              </x-ui.header>
              <div class="flex space-x-2">
                <span
                  class="pr-2 border-r border-gray-700 dark:border-gray-400">{{ date_to_human($blog->published_at, 'd F Y') }}
                </span>
                <span>{{ $blog->read_minutes }}</span>
              </div>
            </div>
            <div class="truncate">
              {{ $blog->description }}
            </div>
          </x-ui.card>
        </a>
      @endforeach
    </div>
  </div>
</x-layout.landing>
