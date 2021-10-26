<div class="flex-1">
    <x-ui.card class="w-full mx-auto p-8">
        <div class="">
            <x-ui.header class="font-semibold text-lg pb-2 border-b border-gray-200">User Details</x-ui.header>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-2 mb-4">
                <div class="font-semibold">
                    Name
                </div>
                <div class="col-span-3">
                    {{ $user->name }}
                </div>
                <div class="font-semibold">
                    Email
                </div>
                <div class="col-span-3">
                    {{ $user->email }}
                </div>
                <div class="font-semibold">
                    Phone Number
                </div>
                <div class="col-span-3">
                    {{ $user->phone_number }}
                </div>
                <div class="font-semibold">
                    Address
                </div>
                <div class="col-span-3">
                    {{ $user->address }}
                </div>
            </div>
        </div>


        <x-ui.header class="font-semibold text-lg border-b border-gray-200">Transactions</x-ui.header>
        <x-ui.table>
            <thead>
                <tr>
                    <x-ui.table-header>ID</x-ui.table-header>
                    <x-ui.table-header>Package</x-ui.table-header>
                    <x-ui.table-header>Status</x-ui.table-header>
                    <x-ui.table-header>Gross Total</x-ui.table-header>
                    <x-ui.table-header>Discount</x-ui.table-header>
                    <x-ui.table-header>Net Total</x-ui.table-header>
                    <x-ui.table-header>Created At</x-ui.table-header>
                </tr>
            </thead>

            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <x-ui.table-data>{{ $transaction->id }}</x-ui.table-data>
                    <x-ui.table-data>{{ $transaction->package->name }}</x-ui.table-data>
                    <x-ui.table-data>{{ $transaction->status }}</x-ui.table-data>
                    <x-ui.table-data>{{ $transaction->gross_total }}</x-ui.table-data>
                    <x-ui.table-data>{{ $transaction->discount }}</x-ui.table-data>
                    <x-ui.table-data>{{ $transaction->net_total }}</x-ui.table-data>
                    <x-ui.table-data>{{ date_to_human($transaction->created_at) }}</x-ui.table-data>
                </tr>
                @endforeach
            </tbody>

            <x-slot name="footer">
                <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
                    <div>
                        <p class="text-sm leading-5">
                            Showing
                            <span class="font-medium">{{ $transactions->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $transactions->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $transactions->total() }}</span>
                            results
                        </p>
                    </div>
                    <div class="inline-block">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </x-slot>
        </x-ui.table>
    </x-ui.card>
</div>