<div class="grid grid-cols-6 gap-2">
    <div class="col-span-full lg:col-span-1">
        <x-ui.card class="flex-col hidden p-4 lg:flex">
            <a wire:click="changeSection('general')" class="px-2 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'general' ? 'text-primary-500' : '' }}">General</a>
            <a wire:click="changeSection('balance')" class="px-2 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'balance' ? 'text-primary-500' : '' }}">Balance</a>
            <a wire:click="changeSection('instrument')" class="px-2 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'instrument' ? 'text-primary-500' : '' }}">Instrument</a>
            <a wire:click="changeSection('setup')" class="px-2 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'setup' ? 'text-primary-500' : '' }}">Setup</a>
            <a wire:click="changeSection('mistake')" class="px-2 py-3 text-sm font-semibold tracking-widest uppercase cursor-pointer hover:text-primary-500 {{ $section === 'mistake' ? 'text-primary-500' : '' }}">Mistake</a>
        </x-ui.card>

        <x-ui.select wire:model="section" class="block w-full lg:hidden">
            <option value="general">General</option>
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
