<x-layout.admin>
  <x-ui.card class="flex flex-col max-w-3xl p-6 mx-auto space-y-4">
    <div class="flex flex-col space-y-1">
      <x-ui.header class="text-4xl font-semibold">
        {{ $blog->title }}
      </x-ui.header>
      <div class="flex space-x-2">
        <span
          class="pr-2 border-r border-gray-700 dark:border-gray-400">{{ date_to_human($blog->publish_date, 'd F Y') }}
        </span>
        <span>{{ $blog->read_minutes }}</span>
      </div>
    </div>

    <div class="prose">
      {!! $blog->body !!}
    </div>
  </x-ui.card>
</x-layout.admin>
