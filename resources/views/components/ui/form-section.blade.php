<div class="flex flex-col gap-2">
    <label class="text-sm">
        {{ $field }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    {{ $slot }}
</div>