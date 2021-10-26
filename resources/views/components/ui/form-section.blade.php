<div {{ $attributes->merge(['class'=>'flex flex-col gap-2 mb-1']) }}>
    <label class="text-sm">
        {{ $field }}
        <span class="{{ $required == 'true' ? 'inline-block' : 'hidden' }} text-red-500">*</span>
    </label>
    {{ $slot }}
</div>