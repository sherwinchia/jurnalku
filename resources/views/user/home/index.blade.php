<x-layout.user header="Home">
    <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-4">
        <template x-for="i in 4" :key="i">
            <div class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-400">Total Users</span>
                        <span class="text-lg font-semibold">100,221</span>
                    </div>
                    <div class="p-10 bg-gray-200 rounded-md"></div>
                </div>
                <div>
                    <span class="inline-block px-2 text-sm text-white bg-green-300 rounded">14%</span>
                    <span>from 2019</span>
                </div>
            </div>
        </template>
    </div>
</x-layout.user>