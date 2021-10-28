@if(strtolower($type) == "success")
<span class="bg-green-100 text-green-500 rounded-full px-4 py-1">
    {{ $slot }}
</span>
@elseif(strtolower($type) == "pending")
<span class="bg-yellow-100  text-yellow-500 rounded-full px-4 py-1">
    {{ $slot }}
</span>
@elseif(strtolower($type) == "fail")
<span class="bg-red-100 text-red-500 rounded-full px-4 py-1">
    {{ $slot }}
</span>
@else
<span class="bg-gray-100  text-gray-500 rounded-full px-4 py-1">
    {{ $slot }}
</span>
@endif