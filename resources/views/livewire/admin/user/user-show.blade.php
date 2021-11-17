<div class="flex-1">
    <x-ui.card class="w-full p-6 mx-auto">
        <div class="">
            <x-ui.header class="pb-2 text-lg font-semibold border-b border-gray-200">User Details</x-ui.header>
            <div class="flex flex-col mb-2 lg:flex-row">
                <div class="w-1/2">
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
                        <div class="font-semibold">
                            Name
                        </div>
                        <div class="col-span-2">
                            {{ $user->name }}
                        </div>
                        <div class="font-semibold">
                            Email
                        </div>
                        <div class="col-span-2">
                            {{ $user->email }}
                        </div>
                        <div class="font-semibold">
                            Phone Number
                        </div>
                        <div class="col-span-2">
                            {{ $user->phone_number }}
                        </div>
                        <div class="font-semibold">
                            Address
                        </div>
                        <div class="col-span-2">
                            {{ $user->address }}
                        </div>
                        <div class="font-semibold">
                            Birthday
                        </div>
                        <div class="col-span-2">

                        </div>
                    </div>
                </div>
                <div class="w-1/2">
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
                        <div class="font-semibold">
                            Subscription
                        </div>
                        <div class="col-span-2">
                            {{ $user->subscription->type }}
                        </div>
                        <div class="font-semibold">
                            Expiry
                        </div>
                        <div class="col-span-2">
                            {{ date_to_human($user->subscription->expired_at,"d M Y") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <x-ui.header class="text-lg font-semibold border-b border-gray-200">Transactions</x-ui.header>
        <x-ui.table>
            <thead>
                <x-ui.table-row>
                    <x-ui.table-header>ID</x-ui.table-header>
                    <x-ui.table-header>Ref</x-ui.table-header>
                    <x-ui.table-header>Merchant Ref</x-ui.table-header>
                    <x-ui.table-header>Gross Total</x-ui.table-header>
                    <x-ui.table-header>Discount</x-ui.table-header>
                    <x-ui.table-header>Net Total</x-ui.table-header>
                    <x-ui.table-header>Date</x-ui.table-header>
                    <x-ui.table-header>Status</x-ui.table-header>
                    <x-ui.table-header>Action</x-ui.table-header>
                </x-ui.table-row>
            </thead>

            <tbody>
                @foreach ($transactions as $transaction)
                <x-ui.table-row>
                    <x-ui.table-data>{{ $transaction->id }}</x-ui.table-data>
                    <x-ui.table-data>{{ $transaction->reference }}</x-ui.table-data>
                    <x-ui.table-data>{{ $transaction->merchant_ref }}</x-ui.table-data>
                    <x-ui.table-data>{{ decimal_to_human($transaction->gross_total, "Rp") }}</x-ui.table-data>
                    <x-ui.table-data>{{ decimal_to_human($transaction->discount, "Rp") }}</x-ui.table-data>
                    <x-ui.table-data>{{ decimal_to_human($transaction->net_total, "Rp") }}</x-ui.table-data>
                    <x-ui.table-data>{{ date_to_human($transaction->created_at, "d M Y") }}</x-ui.table-data>
                    <x-ui.table-data>
                        <x-ui.status type="{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</x-ui.status>
                    </x-ui.table-data>
                    <x-ui.table-data>
                        <div class="flex text-gray-600">
                            <a class="mx-1 text-lg" role="button" href="{{ route('admin.transactions.show', $transaction->id)
                            }}">
                                <x-icon.eye class="w-5 h-5" />
                            </a>
                        </div>
                    </x-ui.table-data>
                </x-ui.table-row>
                @endforeach
            </tbody>

            <x-slot name="footer">
                <div class="mt-4 sm:flex-1 sm:flex sm:items-center sm:justify-between work-sans">
                    <div class="py-3">
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
