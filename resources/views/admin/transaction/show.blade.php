@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | {{ $transaction->merchant_ref }}</title>
  <meta name="description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta name="robots" content="noindex, nofollow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
@endsection
<x-layout.admin>
  <x-slot name="breadcrumbs">
    {{ Breadcrumbs::render('admin.transactions.show', $transaction) }}
  </x-slot>
  <div class="flex-1">
    <x-ui.card class="max-w-2xl p-6 mx-auto ">
      <div class="flex items-center justify-between pb-2 mb-2 border-b border-gray-300 dark:border-gray-600">
        <x-ui.header>Transaction Details</x-ui.header>
        <div class="p-1">
          <x-ui.status type="{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</x-ui.alert>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-1 mb-3 lg:grid-cols-3">
        <div class="">
          Ref
        </div>
        <div class="col-span-2">
          {{ $transaction->reference }}
        </div>
        <div class="">
          Merchant Ref
        </div>
        <div class="col-span-2">
          {{ $transaction->merchant_ref }}#{{ $transaction->id }}
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
        @if ($transaction->note)
          <div class="">
            Note
          </div>
          <div class="col-span-2">
            {{ $transaction->note }}
          </div>
        @endif
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
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-300 dark:border-gray-600">
          @foreach ($transaction->items as $transactionItem)
            <div>
              <h2 class="font-medium">{{ data_get($transactionItem, 'package.name', '-') }}</h2>
              {{-- <p class="text-sm font-normal text-gray-700">
                {{ data_get($transactionItem, 'package.description', '-') }}</p> --}}
            </div>
            <span>{{ decimal_to_human(data_get($transactionItem, 'package.price', ''), 'Rp') }}</span>
          @endforeach
        </div>
      </div>

      @if ($transaction->status == 'success')
        <div class="flex flex-col">
          @if ($transaction->discount > 0)
            <div class="flex justify-between">
              <span class="text-sm">Subtotal</span>
              <span>{{ decimal_to_human($transaction->gross_total, 'Rp') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-sm">Discount
                @if (data_get($transaction, 'promocode.code') != '')
                  <span class="text-xs italic">({{ data_get($transaction, 'promocode.code') }})</span>
                @endif
              </span>
              <span>{{ decimal_to_human($transaction->discount, 'Rp') }}</span>
            </div>
          @endif

          <div class="flex justify-between font-medium">
            <span class="text-sm">Total</span>
            <span>{{ decimal_to_human($transaction->net_total, 'Rp') }}</span>
          </div>
        </div>
      @endif

    </x-ui.card>
  </div>
</x-layout.admin>
