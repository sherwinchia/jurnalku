<div class="grid grid-cols-6 gap-2">
  <div class="flex flex-col space-y-2 col-span-full lg:col-span-1">
    <x-ui.card class="p-4">
      <h2>My account</h2>
      @if(isset(current_user()->subscription))
      <p class="text-sm text-gray-300">Active until {{ current_user()->subscription->expired_at }}</p>
      <p class="text-sm text-gray-300">Max portfolio {{ current_user()->max_portfolio }}</p>
      @else
      <p class="text-sm text-gray-300">Account inactive</p>
      @endif
    </x-ui.card>
    <x-ui.card class="flex-col hidden overflow-hidden lg:flex">
      <x-ui.alt-navbar-link wire:click="changeSection('topup')"
        class="{{ $section === 'topup' ? 'text-primary-500 border-l-4 bg-gray-50' : '' }}">Top Up
      </x-ui.alt-navbar-link>
      <x-ui.alt-navbar-link wire:click="changeSection('history')"
        class="{{ $section === 'history' ? 'text-primary-500 border-l-4 bg-gray-50' : '' }}">Purchase History
      </x-ui.alt-navbar-link>
    </x-ui.card>
    <x-ui.select wire:model="section" class="block w-full lg:hidden">
      <option value="topup">Top Up</option>
      <option value="history">Purchase History</option>
    </x-ui.select>
  </div>
  <x-ui.card class="p-4 col-span-full lg:col-span-5">
    @if ($section === 'topup')
      <livewire:user.billing.buy-form />
    @elseif($section === "history")
      <livewire:user.transaction.transaction-table :merchant_ref="$merchant_ref"/>
    @endif
  </x-ui.card>
</div>
