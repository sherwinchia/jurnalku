<div class="flex flex-col gap-2 mb-1">
    <label class="text-sm">
        {{ $field }}
        @if(isset($required) && $required == true)
        <span class="text-red-500">*</span>
        @endif
    </label>
    {{ $slot }}
</div>