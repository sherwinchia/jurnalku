<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.transactions.show', $transaction) }}
    </x-slot>
    <div class="flex-1">
        <x-ui.card class="max-w-2xl p-6 mx-auto ">
            <div class="flex items-center justify-between pb-2 mb-2 border-b border-gray-300">
                <x-ui.header>Transaction Details</x-ui.header>
                <div class="p-1">
                    <x-ui.status type="{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</x-ui.alert>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-1 mb-3 lg:grid-cols-3">
                <div class="">
                    ID
                </div>
                <div class="col-span-2">
                    {{ $transaction->reference }}#{{ $transaction->id }}
                </div>
                <div class="">
                    Date
                </div>
                <div class="col-span-2">
                    {{ date_to_human($transaction->created_at, 'd F Y, h:i A') }}
                </div>
                <div class="">
                    Latest
                </div>
                <div class="col-span-2">
                    {{ date_to_human($transaction->updated_at, 'd F Y, h:i A') }}
                </div>
            </div>

            <div class="mb-3">
                <h5 class="text-lg font-semibold">Buyer Details</h5>
                <div class="grid grid-cols-1 gap-1 lg:grid-cols-3">


                    <div class="">
                        Name
                    </div>
                    <div class="col-span-2">
                        {{ data_get($transaction, 'user.name', '-') }}
                    </div>
                    <div class="">
                        Email
                    </div>
                    <div class="col-span-2">
                        {{ data_get($transaction, 'user.email', '-') }}
                    </div>
                    <div class="">
                        Phone Number
                    </div>
                    <div class="col-span-2">
                        {{ data_get($transaction, 'user.phone_number', '-') }}
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h5 class="text-lg font-semibold">Package Details</h5>
                <div class="grid grid-cols-1 gap-1 lg:grid-cols-3">
                    <div class="">
                        Name
                    </div>
                    <div class="col-span-2">
                        {{ data_get($transaction, 'package.name') }}
                    </div>
                    <div class="">
                        Duration
                    </div>
                    <div class="col-span-2">
                        {{ data_get($transaction, 'package.duration')  }} days
                    </div>
                    <div class="">
                        Price
                    </div>
                    <div class="col-span-2">
                        {{ decimal_to_human(data_get($transaction, 'package.price')  , "Rp") }}
                    </div>
                </div>
            </div>

            @if($transaction->status == "success")
            <div>
                <h5 class="text-lg font-semibold ">Payment Details</h5>
                <div class="grid grid-cols-1 gap-1 lg:grid-cols-3">
                    <div class="">
                        Gross Total
                    </div>
                    <div class="col-span-2">
                        {{ decimal_to_human($transaction->gross_total, "Rp") }}
                    </div>
                    <div class="">
                        Discount <span class="text-xs italic">({{ $transaction->promoCode->code ?? '' }})</span>
                    </div>
                    <div class="col-span-2">
                        -{{ decimal_to_human($transaction->discount, "Rp") }}
                    </div>
                    <div class="">
                        Net Total
                    </div>
                    <div class="col-span-2">
                        {{ decimal_to_human($transaction->net_total, "Rp") }}
                    </div>
                </div>
            </div>
            @endif

        </x-ui.card>
    </div>
</x-layout.admin>
