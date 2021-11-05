<div class="flex-col justify-between p-3 m-2 text-white rounded-md bg-primary-500"
:class="{'hidden': !isSidebarOpen, 'lg:flex ': isSidebarOpen}">
    @foreach($portfolios as $portfolio)
    <div>
        <span class="text-sm tracking-widest">{{ $portfolio->name }}</span>
        <div class="flex">
            <span class="text-xs tracking-widest">{{ $portfolio->currency }}</span>
            <span class="{{ $portfolio->calculate_balance > 0 ? 'text-green-500' : 'text-red-500' }}">{{ decimal_to_human($portfolio->calculate_balance)  }}</span>
        </div>
    </div>
    @endforeach
</div>
