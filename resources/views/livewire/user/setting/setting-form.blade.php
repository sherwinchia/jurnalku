<div class="grid grid-cols-6 gap-2">
    <div class="col-span-full lg:col-span-1">
        <x-ui.card class="flex-col hidden overflow-hidden lg:flex">
            <a wire:click="changeSection('general')" class="px-5 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'general' ? 'text-primary-500 bg-primary-100' : '' }}">General</a>
            <a wire:click="changeSection('portfolio')" class="px-5 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'portfolio' ? 'text-primary-500 bg-primary-100' : '' }}">Portfolio</a>
            <a wire:click="changeSection('instrument')" class="px-5 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'instrument' ? 'text-primary-500 bg-primary-100' : '' }}">Instrument</a>
            <a wire:click="changeSection('setup')" class="px-5 py-3 border-b text-sm font-semibold tracking-widest uppercase border-gray-300 cursor-pointer hover:text-primary-500 {{ $section === 'setup' ? 'text-primary-500 bg-primary-100 ' : '' }}">Setup</a>
            <a wire:click="changeSection('mistake')" class="px-5 py-3 text-sm font-semibold tracking-widest uppercase cursor-pointer hover:text-primary-500 {{ $section === 'mistake' ? 'text-primary-500 bg-primary-100' : '' }}">Mistake</a>
        </x-ui.card>

        <x-ui.select wire:model="section" class="block w-full lg:hidden">
            <option value="general">General</option>
            <option value="portfolio">Portfolio</option>
            <option value="instrument">Instrument</option>
            <option value="setup">Setup</option>
            <option value="mistake">Mistake</option>
        </x-ui.select>
    </div>
    <x-ui.card class="p-4 col-span-full lg:col-span-5">
        @if($section === "general")
        <livewire:user.setting.general-form>
        @elseif($section === "portfolio")
        <livewire:user.setting.portfolio-form>
        @elseif($section === "instrument")
        <livewire:user.setting.instrument-form>
        @elseif($section === "setup")
        <livewire:user.setting.setup-form>
        @elseif($section === "mistake")
        <livewire:user.setting.mistake-form>
        @endif
    </x-ui.card>
</div>
