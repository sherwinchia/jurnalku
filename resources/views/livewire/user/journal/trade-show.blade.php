<div class="flex-1">
    <x-ui.card class="max-w-xl p-6 mx-auto">
        <div class="flex items-center justify-between mb-2 border-b border-gray-300">
            <x-ui.header>Trade Details</x-ui.header>
            <x-ui.status type="{{ $trade->status }}">{{ ucfirst($trade->status) }}</x-ui.status>
        </div>

        <div class="grid grid-cols-4 gap-1 mb-3 md:grid-cols-3">
            <div class="flex col-span-2 md:col-span-1">
                <span>Instrument</span>
                <span class="ml-auto">:</span>
            </div>
            <div class="col-span-2">
                {{ $trade->instrument }}
            </div>
            <div class="flex col-span-2 md:col-span-1">
                Quantity
                <span class="ml-auto">:</span>
            </div>
            <div class="col-span-2">
                {{ decimal_to_human($trade->quantity) }}
            </div>
            <div class="flex col-span-2 md:col-span-1">
                Take Profit
                <span class="ml-auto">:</span>
            </div>
            <div class="col-span-2">
                {{ $trade->take_profit }}
            </div>
            <div class="flex col-span-2 md:col-span-1">
                Stop Loss
                <span class="ml-auto">:</span>
            </div>
            <div class="col-span-2">
                {{ $trade->stop_loss }}
            </div>
        </div>

        <div class="mb-3">
            <x-ui.alt-table class="relative w-full">
                <thead>
                    <x-ui.table-row>
                        <x-ui.table-data class="sticky left-0 bg-gray-50 ">

                        </x-ui.table-data>
                        <x-ui.table-data class="font-semibold bg-gray-50">
                            Entry
                        </x-ui.table-data>
                        <x-ui.table-data class="font-semibold bg-gray-50">
                            Exit
                        </x-ui.table-data>
                    </x-ui.table-row>
                </thead>
                <tbody>
                    <x-ui.table-row>
                        <x-ui.table-data class="sticky left-0 bg-gray-50">
                            Date
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->entry_date ? date_to_human($trade->entry_date, "d M Y") : '-' }}
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->exit_date ? date_to_human($trade->exit_date, "d M Y")  : '-'}}
                        </x-ui.table-data>
                    </x-ui.table-row>
                    <x-ui.table-row>
                        <x-ui.table-data class="sticky left-0 bg-gray-50">
                            Time
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->entry_date ? date_to_human($trade->entry_date, "h:i:s") : '-' }}
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->exit_date ? date_to_human($trade->exit_date, "h:i:s")  : '-'}}
                        </x-ui.table-data>
                    </x-ui.table-row>
                    <x-ui.table-row>
                        <x-ui.table-data class="sticky left-0 bg-gray-50">
                            Price
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->entry_price ? decimal_to_human($trade->entry_price) : '-' }}
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->exit_price ? decimal_to_human($trade->exit_price) : '-' }}
                        </x-ui.table-data>
                    </x-ui.table-row>
                    <x-ui.table-row>
                        <x-ui.table-data class="sticky left-0 bg-gray-50">
                            Fee
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->entry_fee ? decimal_to_human($trade->entry_fee) : '-'}}
                        </x-ui.table-data>
                        <x-ui.table-data>
                            {{ $trade->exit_fee ? decimal_to_human($trade->exit_fee)  : '-'}}
                        </x-ui.table-data>
                    </x-ui.table-row>
                    <x-ui.table-row>
                        <x-ui.table-data class="sticky left-0 bg-gray-50">
                            P/L
                        </x-ui.table-data>
                        <x-ui.table-data>
                            @if(isset($trade->exit_date))
                             @if($trade->calculate_net > 0)
                             <span class="text-green-500">{{ decimal_to_human($trade->calculate_net) }} ({{ decimal_to_human($trade->calculate_percentage) }}%)</span>
                             @elseif($trade->calculate_net < 0)
                             <span class="text-red-500">{{ decimal_to_human($trade->calculate_net) }} ({{ decimal_to_human($trade->calculate_percentage) }}%)</span>
                             @else
                             <span class="">{{ decimal_to_human($trade->calculate_net) }} ({{ decimal_to_human($trade->calculate_percentage) }}%)</span>
                             @endif
                            @else
                            -
                            @endif
                        </x-ui.table-data>
                    </x-ui.table-row>
                </tbody>
            </x-ui.alt-table>
        </div>

        <div class="grid grid-cols-4 gap-1 mb-3 md:grid-cols-3">
            <div class="flex col-span-2 md:col-span-1">
                Setup
                <span class="ml-auto">:</span>
            </div>
            <div class="col-span-2">
                {{ $trade->setup ?? '-' }}
            </div>
            <div class="flex col-span-2 md:col-span-1">
                Mistake
                <span class="ml-auto">:</span>
            </div>
            <div class="col-span-2">
                {{ $trade->mistake ?? '-' }}
            </div>
            <div class="flex col-span-2 md:col-span-1">
                Note
                <span class="ml-auto">:</span>
            </div>
            <div class="col-span-2">
                {{ $trade->note ?? '-' }}
            </div>
        </div>

        <!-- <div class="grid grid-cols-4 gap-1 mb-3 md:grid-cols-3">
            Screenshot here
        </div> -->

    </x-ui.card>
</div>
