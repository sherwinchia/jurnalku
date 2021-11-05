<div class="grid grid-cols-6 gap-2">
    <div class="col-span-full lg:col-span-1">
        <x-ui.card class="flex-col hidden overflow-hidden lg:flex">
            <x-ui.alt-navbar-link wire:click="changeSection('general')" class="{{ $section === 'general' ? 'text-primary-500 border-l-4 bg-gray-50' : '' }}">General</x-ui.alt-navbar-link>
            <x-ui.alt-navbar-link wire:click="changeSection('balance')" class="{{ $section === 'balance' ? 'text-primary-500 border-l-4 bg-gray-50' : '' }}">Balance</x-ui.alt-navbar-link>
            <x-ui.alt-navbar-link wire:click="changeSection('instrument')" class="{{ $section === 'instrument' ? 'text-primary-500 border-l-4 bg-gray-50' : '' }}">Instrument</x-ui.alt-navbar-link>
            <x-ui.alt-navbar-link wire:click="changeSection('setup')" class="{{ $section === 'setup' ? 'text-primary-500 border-l-4 bg-gray-50 ' : '' }}">Setup</x-ui.alt-navbar-link>
            <x-ui.alt-navbar-link wire:click="changeSection('mistake')" class="{{ $section === 'mistake' ? 'text-primary-500 border-l-4 bg-gray-50' : '' }}">Mistake</x-ui.alt-navbar-link>
        </x-ui.card>
        <x-ui.select wire:model="section" class="block w-full lg:hidden">
            <option value="general">General</option>
            <option value="portfolio">Portfolio</option>
            <option value="balance">Balance</option>
            <option value="instrument">Instrument</option>
            <option value="setup">Setup</option>
            <option value="mistake">Mistake</option>
        </x-ui.select>
    </div>
    <x-ui.card class="p-4 col-span-full lg:col-span-5">
        @if($section === "general")
        <livewire:user.setting.general-form>
        @elseif($section === "balance")
        <livewire:user.setting.balance-form>
        @elseif($section === "instrument")
        <livewire:user.setting.instrument-form>
        @elseif($section === "setup")
        <livewire:user.setting.setup-form>
        @elseif($section === "mistake")
        <livewire:user.setting.mistake-form>
        @endif
    </x-ui.card>
</div>
