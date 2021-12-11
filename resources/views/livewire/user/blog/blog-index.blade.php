<div>
  <div style="min-height: 60vh" class="flex flex-col justify-between w-full max-w-5xl py-8 mx-auto">
    <div class="flex flex-col space-y-4">
      @foreach ($blogs as $blog)
        <a href="{{ route('user.blogs.show', $blog->slug) }}">
          <x-ui.card class="flex flex-col p-4 space-y-4">
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
            <div>
              {{ $blog->description }}
            </div>
          </x-ui.card>
        </a>
      @endforeach
    </div>
    <div class=" sm:flex sm:items-center sm:justify-between work-sans">
      <div class="py-3">
        <p class="text-sm leading-5">
          Showing
          <span class="font-medium">{{ $blogs->firstItem() }}</span>
          to
          <span class="font-medium">{{ $blogs->lastItem() }}</span>
          of
          <span class="font-medium">{{ $blogs->total() }}</span>
          results
        </p>
      </div>
      <div class="inline-block">
        {{ $blogs->links() }}
      </div>
    </div>
  </div>
</div>
