@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | {{ $blog->title }}</title>
  <meta name="description" content="{{ $blog->description }}" />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | {{ $blog->title }}" />
  <meta property="og:description" content="{{ $blog->description }}" />
  <meta property="og:image" content="{{ asset('images/logo.png') }}" />
  <meta property="og:url" content="{{ route('user.blogs.show', $blog->slug) }}" />
  <meta property="og:site_name" content="{{ ucfirst(config('app.name', 'Laravel')) }} | {{ $blog->title }}" />
  <meta name="twitter:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | {{ $blog->title }}">
  <meta name="twitter:description" content="{{ $blog->description }}">
  <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
  <meta name="twitter:site" content="@sherwin_xnf">
  <meta name="twitter:creator" content="@sherwin_xnf">
@endsection

<x-layout.landing>
  <div style="min-height: 60vh"
    class="grid items-start w-full grid-cols-4 gap-4 py-8 mx-auto lg:gap-6 max-w-7xl dark:text-gray-400">
    <x-ui.card class="flex flex-col p-6 m-4 space-y-4 lg:m-0 col-span-full lg:col-span-3">
      <div class="flex flex-col space-y-1">
        <x-ui.header class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
          {{ $blog->title }}
        </x-ui.header>
        <div class="flex space-x-2 text-xs">
          <span
            class="pr-2 border-r border-gray-700 dark:border-gray-400">{{ date_to_human($blog->published_at, 'd F Y') }}
          </span>
          <span>{{ $blog->read_minutes }}</span>
        </div>
      </div>
      <div class="prose text-gray-600 dark:text-gray-400">{!! $blog->body !!}</div>
    </x-ui.card>

    <div class="sticky flex flex-col m-4 space-y-4 col-span-full lg:col-span-1 top-4 lg:m-0">
      <x-ui.header class="pb-2 text-xl font-semibold text-gray-700 border-b dark:text-gray-200">More Blogs</x-ui.header>
      @foreach ($other_blogs as $blog)
        <a href="{{ route('user.blogs.show', $blog->slug) }}">
          <x-ui.card class="sticky flex flex-col p-4 space-y-4">
            <div class="flex flex-col space-y-1">
              <x-ui.header class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $blog->title }}
              </x-ui.header>
              <div class="flex space-x-2 text-xs">
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
