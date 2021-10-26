<div class="flex-1">
    <x-ui.card class=" max-w-2xl mx-auto p-8">
        <div class="flex justify-between items-center border-b border-gray-300 mb-2">
            <x-ui.header>Transaction Details</x-ui.header>
            <div class="p-1">
                <x-ui.status type="{{ $transaction->status }}">{{ $transaction->status }}</x-ui.alert>
            </div>
        </div>

        <div class=" grid grid-cols-1 lg:grid-cols-3 gap-1 mb-3">
            <div class="">
                ID
            </div>
            <div class="col-span-2">
                INV1282AXT12 # {{ $transaction->id }}
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
            <h5 class="text-lg font-semibold">Package Details</h5>
            <div class=" grid grid-cols-1 lg:grid-cols-3 gap-1">
                <div class="">
                    Name
                </div>
                <div class="col-span-2">
                    {{ $transaction->package->name }}
                </div>
                <div class="">
                    Duration
                </div>
                <div class="col-span-2">
                    {{ $transaction->package->duration }} days
                </div>
                <div class="">
                    Price
                </div>
                <div class="col-span-2">
                    {{ decimal_to_human($transaction->package->price , "Rp") }}
                </div>
            </div>
        </div>

        @if($transaction->status == "Success")
        <div>
            <h5 class=" text-lg font-semibold">Payment Details</h5>
            <div class=" grid grid-cols-1 lg:grid-cols-3 gap-1">
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