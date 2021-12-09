@if ($paginator->hasPages())
<nav
    role="navigation"
    aria-label="Pagination Navigation"
    class="flex items-center justify-between w-full py-3"
>
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
        <span
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400"
        >
            {!! __('pagination.previous') !!}
        </span>
        @else
        <button
            type="button"
            wire:click="previousPage"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400 hover:text-gray-500 focus:outline-none active:bg-gray-100 active:text-gray-700"
        >
            {!! __('pagination.previous') !!}
        </button>
        @endif @if ($paginator->hasMorePages())
        <button
            type="button"
            wire:click="nextPage"
            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400 hover:text-gray-500 focus:outline-none active:bg-gray-100 active:text-gray-700"
        >
            {!! __('pagination.next') !!}
        </button>
        @else
        <span
            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400"
        >
            {!! __('pagination.next') !!}
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <span class="relative z-0 inline-flex shadow-sm">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <span
                    aria-disabled="true"
                    aria-label="{{ __('pagination.previous') }}"
                >
                    <span
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400 rounded-l-md"
                        aria-hidden="true"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </span>
                </span>
                @else
                <button
                    type="button"
                    wire:click="previousPage"
                    rel="prev"
                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400 rounded-l-md hover:text-gray-400 focus:z-10 focus:outline-none active:bg-gray-100 active:text-gray-500"
                    aria-label="{{ __('pagination.previous') }}"
                >
                    <svg
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <span aria-disabled="true">
                    <span
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 bg-white border border-gray-300 cursor-default  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400"
                        >{{ $element }}</span
                    >
                </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element)) @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 border border-gray-300 cursor-default  dark:border-gray-600 bg-primary-100 dark:bg-primary-500 text-primary-500 dark:text-primary-100"
                        >{{ $page }}</span
                    >
                </span>
                @else
                <button
                    type="button"
                    wire:click="gotoPage({{ $page }})"
                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400 hover:text-gray-500 focus:z-10 focus:outline-none active:bg-gray-100 active:text-gray-700"
                    aria-label="{{ __('pagination.goto_page', ['page' => $page]) }}"
                >
                    {{ $page }}
                </button>
                @endif @endforeach @endif @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <button
                    type="button"
                    wire:click="nextPage"
                    rel="next"
                    class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400 rounded-r-md hover:text-gray-400 focus:z-10 focus:outline-none active:bg-gray-100 active:text-gray-500"
                    aria-label="{{ __('pagination.next') }}"
                >
                    <svg
                        class="w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
                @else
                <span
                    aria-disabled="true"
                    aria-label="{{ __('pagination.next') }}"
                >
                    <span
                        class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default  dark:border-gray-600 dark:bg-dark-200 dark:text-gray-400 rounded-r-md"
                        aria-hidden="true"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </span>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
