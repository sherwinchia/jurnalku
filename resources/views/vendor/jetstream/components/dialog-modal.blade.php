@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        @if(isset($title))
        <div
            class="flex items-center justify-between py-2 text-lg font-medium border-b  dark:border-gray-600"
        >
            {{ $title }}
        </div>
        @endif

        <div class="mt-4">
            {{ $content }}
        </div>
    </div>

    <div class="px-6 py-4 text-right bg-gray-100 dark:bg-dark-200">
        {{ $footer }}
    </div>
</x-jet-modal>
