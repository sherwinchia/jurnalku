<div class="grid grid-cols-6 gap-2">
  <div class="col-span-full lg:col-span-1">
    <x-ui.card class="flex-col hidden overflow-hidden lg:flex">
      <x-ui.alt-navbar-link wire:click="changeSection('trial')"
        class="{{ $section === 'trial' ? 'text-primary-500 border-l-4 bg-gray-50 dark:bg-dark-50' : '' }}">
        Trial</x-ui.alt-navbar-link>
      <x-ui.alt-navbar-link wire:click="changeSection('banner')"
        class="{{ $section === 'banner' ? 'text-primary-500 border-l-4 bg-gray-50 dark:bg-dark-50' : '' }}">
        Banner</x-ui.alt-navbar-link>
      <x-ui.alt-navbar-link wire:click="changeSection('tos')"
        class="{{ $section === 'tos' ? 'text-primary-500 border-l-4 bg-gray-50 dark:bg-dark-50' : '' }}">
        Terms of Service</x-ui.alt-navbar-link>
      <x-ui.alt-navbar-link wire:click="changeSection('policy')"
        class="{{ $section === 'policy' ? 'text-primary-500 border-l-4 bg-gray-50 dark:bg-dark-50' : '' }}">
        Privacy Policy</x-ui.alt-navbar-link>
    </x-ui.card>
    <x-ui.select wire:model="section" class="block w-full lg:hidden">
      <option value="trial">Trial</option>
      <option value="banner">Banner</option>
      <option value="tos">Terms of Service</option>
      <option value="policy">Privacy Policy</option>
    </x-ui.select>
  </div>
  <x-ui.card class="p-4 col-span-full lg:col-span-5">
    @if ($section === 'trial')
      <livewire:admin.setting.trial-form />
    @elseif($section === "banner")
      <livewire:admin.setting.banner-form />
    @elseif($section === "tos")
      <livewire:admin.setting.terms-form />
    @elseif($section === "policy")
      <livewire:admin.setting.policy-form />
    @endif
  </x-ui.card>
</div>
