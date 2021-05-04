<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-400 active:bg-indigo-600 focus:outline-none focus:border-indigo-600 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
