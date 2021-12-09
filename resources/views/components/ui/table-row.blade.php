<tr {{ $attributes->
    merge(['class'=>'border-b border-gray-200 dark:border-gray-600']) }}>
    {{
        $slot
    }}
</tr>
