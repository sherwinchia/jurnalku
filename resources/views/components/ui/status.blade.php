@if(strtolower($type) == "success" || strtolower($type) == "win" )
<span class="px-4 py-1 text-green-500 bg-green-100 rounded-full">
    {{ $slot }}
</span>
@elseif(strtolower($type) == "pending" || strtolower($type) == "open")
<span class="px-4 py-1 text-yellow-500 bg-yellow-100 rounded-full">
    {{ $slot }}
</span>
@elseif(strtolower($type) == "fail" || strtolower($type) == "lose")
<span class="px-4 py-1 text-red-500 bg-red-100 rounded-full">
    {{ $slot }}
</span>
@else
<span class="px-4 py-1 text-gray-500 bg-gray-100 rounded-full">
    {{ $slot }}
</span>
@endif
