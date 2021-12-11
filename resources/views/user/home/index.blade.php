<x-layout.landing>
  @if ($promotionBanner['active'])
    {!! $promotionBanner['html'] !!}
  @endif

  <div class="px-4">
    <div
      class="relative flex flex-col items-center justify-center w-full mx-auto mt-4 overflow-hidden border border-transparent lg:mt-6 rounded-xl max-w-7xl"
      style="height: 60vh;">
      <img src="{{ asset('images/landing-background.jpg') }}" alt="background"
        class="absolute inset-0 z-0 object-cover w-full h-full">
      <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-800 to-black opacity-80"></div>
      <div class="z-20 flex flex-col max-w-4xl p-8 mx-auto my-4 space-y-6 text-center">
        <h1 class="text-2xl font-semibold text-white md:text-4xl lg:text-5xl ">The only
          <span class="text-primary-500">
            trading journal
          </span>
          you need.
        </h1>
        <p class="leading-6 text-gray-300 lg:text-lg">
          The only trade journal you need to track all of your trading. Simple and intuitive design make it easy for
          newcomer to utilize the platform. {{ config('app.name') }} is suitable for all type of investment.
        </p>
        <div>
          <a href="{{ route('register') }}"
            class="px-4 py-2 mt-2 text-lg font-medium text-white rounded-lg bg-primary-500 md:mt-0 md:ml-4">
            Try now
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="px-4 pt-8 pb-8 lg:py-16 " style="height: 50vh;">
    <div class="flex flex-col h-full mx-auto lg:flex-row max-w-7xl">
      <div class="flex flex-col items-start justify-center flex-1 pb-4 pr-20 space-y-4 md:pb-0">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 md:text-2xl lg:text-3xl">Journal your trade
        </h2>
        <p class="font-normal">
          Track every single trade
        </p>
      </div>
      <div class="flex-1">
        <div class="relative h-full overflow-hidden border rounded-lg shadow-lg">
          <img src="{{ asset('images/jurnalku-dashboard.png') }}" alt=""
            class="absolute object-cover object-left-top w-full h-full">
        </div>
      </div>
    </div>
  </div>

  <div class="px-4 pb-8 lg:py-16 " style="height: 50vh;">
    <div class="flex flex-col h-full mx-auto lg:flex-row-reverse max-w-7xl">
      <div class="flex flex-col items-start justify-center flex-1 pb-4 pl-0 space-y-4 lg:pl-20 md:pb-0">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 md:text-2xl lg:text-3xl">Improve</h2>
        <p class="font-normal">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deleniti aspernatur at laudantium sit error iure
          optio dicta, obcaecati eaque laborum doloribus dolore iste. Minima, sit ad soluta ex eum consequuntur?
        </p>
      </div>
      <div class="flex-1">
        <div class="relative h-full overflow-hidden border rounded-lg shadow-lg">
          <img src="{{ asset('images/jurnalku-trades.png') }}" alt=""
            class="absolute object-cover object-left-top w-full h-full">
        </div>
      </div>
    </div>
  </div>

  <div
    class="px-4 py-16 bg-gradient-to-r from-primary-600 via-primary-500 to-primary-600 dark:from-dark-300 dark:to-dark-300">
    <div class="flex flex-col h-full mx-auto max-w-7xl">
      <h2 class="mb-10 text-xl font-semibold text-white md:text-2xl lg:text-3xl">Why
        {{ ucfirst(config('app.name')) }}</h2>
      <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-col space-y-2 ">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.emoji-happy />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Simple
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.chart-pie />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Chart
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.currency-dollar />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Currency
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.duplicate />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Portfolio
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.cloud />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Cloud
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.qrcode />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Authentication
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.moon />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg ">
            Dark Mode
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="px-4 py-8 md:py-24">
    <div class="flex flex-col mx-auto lg:flex-row max-w-7xl">
      <div class="flex flex-col items-start justify-center flex-1">
        <h2 class="text-xl font-semibold text-gray-700 md:text-2xl lg:text-3xl dark:text-gray-300">Works with different
          kinds of trading instrument</h2>
        <p class="text-lg">
          {{ config('app.name') }} support wide range of market and currency.
        </p>
      </div>
      <div class="flex flex-wrap justify-center flex-1 space-x-2 space-y-2 text-gray-700 dark:text-gray-300">
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-24 h-24 md:w-28 md:h-28 lg:w-32 lg:h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Stocks</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-24 h-24 md:w-28 md:h-28 lg:w-32 lg:h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Crypto</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-24 h-24 md:w-28 md:h-28 lg:w-32 lg:h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Forex</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-24 h-24 md:w-28 md:h-28 lg:w-32 lg:h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Gold</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-24 h-24 md:w-28 md:h-28 lg:w-32 lg:h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Others</span>
        </div>
      </div>
    </div>
  </div>

  <div class="px-4 py-8 text-gray-700 dark:text-gray-300" id="pricing">
    <div class="flex flex-col mx-auto space-y-4 max-w-7xl">
      <h2 class="text-xl font-semibold md:text-center md:text-2xl lg:text-3xl">Pricing</h2>
      <div class="grid w-full max-w-5xl grid-cols-1 gap-10 mx-auto md:grid-cols-2 lg:grid-cols-3">
        @foreach ($packages as $package)
          @if ($package->price >= 1)
            <x-ui.card class="flex flex-col items-start p-6 ">
              <div class="pb-8">
                <h2 class="text-xl font-semibold lg:text-2xl text-primary-500">{{ $package->name }}</h2>
                <p class="text-sm font-normal">{!! $package->description !!}</p>
                <span>{{ decimal_to_human($package->price, 'Rp') }}</span>
              </div>
              <a href="{{ route('register') }}"
                class="px-2 py-1 font-medium text-white border-2 rounded-lg border-primary-500 bg-primary-500 dark:text-gray-200">
                {{ $package->price == 0 ? 'Try now!' : 'Sign Up' }}
              </a>
            </x-ui.card>
          @endif
        @endforeach
        @foreach ($packages as $package)
          @if ($package->price < 1)
            <x-ui.card class="flex flex-col items-start p-6">
              <div class="pb-8">
                <h2 class="text-xl font-semibold lg:text-2xl text-primary-500">{{ $package->name }}</h2>
                <p class="text-sm font-normal">{!! $package->description !!}</p>
                <span>{{ decimal_to_human($package->price, 'Rp') }}</span>
              </div>
              <a href="{{ route('register') }}"
                class="px-2 py-1 font-medium text-white border-2 rounded-lg border-primary-500 bg-primary-500 dark:text-gray-200">
                {{ $package->price == 0 ? 'Try now!' : 'Sign Up' }}
              </a>
            </x-ui.card>
          @endif
        @endforeach
      </div>
    </div>
  </div>

  <div class="px-4 pt-16 pb-16 text-gray-700 dark:text-gray-300" id="faq">
    <div class="flex flex-col mx-auto space-y-4 max-w-7xl">
      <h2 class="text-xl font-semibold md:text-center md:text-2xl lg:text-3xl">Frequently Asked Questions</h2>
      <div class="mx-auto" x-data="{selected:1}">
        <ul class="flex flex-col w-full max-w-4xl space-y-4">
          @foreach ($faqs as $index => $faq)
            <li class="relative border border-gray-200 dark:border-gray-600">
              <button type="button" class="w-full px-3 py-2 text-left focus:outline-none "
                x-on:click="selected !== {{ $index + 1 }} ? selected = {{ $index + 1 }} : selected = null">
                <div class="flex items-center justify-between">
                  <span class="max-w-3xl">
                    {{ $faq['question'] }}
                  </span>
                  <x-icon.chevron-down class="w-4 h-4 transform"
                    x-bind:class="selected == {{ $index + 1 }} ? 'rotate-180' : ''" />
                </div>
              </button>
              <div class="relative overflow-hidden transition-all duration-700 max-h-0" style=""
                x-ref="container{{ $index + 1 }}"
                x-bind:style="selected == {{ $index + 1 }} ? 'max-height: ' + $refs.container{{ $index + 1 }}.scrollHeight + 'px' : ''">
                <div class="px-3 pb-2">
                  {{ $faq['answer'] }}
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</x-layout.landing>
