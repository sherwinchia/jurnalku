@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | Home</title>
  <meta name="description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  {{-- <meta property="og:type" content="article" /> --}}
  <meta property="og:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Home" />
  <meta property="og:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta property="og:image" content="{{ asset('images/logo.png') }}" />
  <meta property="og:url" content="{{ route('user.home.index') }}" />
  <meta property="og:site_name" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Home" />
  <meta name="twitter:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Home">
  <meta name="twitter:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading.">
  <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
  <meta name="twitter:site" content="@sherwin_xnf">
  <meta name="twitter:creator" content="@sherwin_xnf">
@endsection

<x-layout.landing>
  @if ($promotionBanner['active'])
    {!! $promotionBanner['html'] !!}
  @endif

  <div class="px-4 ">
    <div
      class="relative flex flex-col items-center justify-center w-full mx-auto mt-4 overflow-hidden border border-transparent lg:mt-6 rounded-xl max-w-7xl"
      style="height: 60vh;">
      <img src="{{ asset('images/landing-background.jpg') }}" alt="background image"
        class="absolute inset-0 z-0 object-cover w-full h-full">
      <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-800 to-black opacity-80"></div>
      <div class="z-20 flex flex-col max-w-4xl p-8 mx-auto my-4 space-y-6 text-center ">
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
        <svg class="absolute right-0 hidden lg:block" width="100" height="450" fill="none" viewBox="0 0 100 450"
          aria-hidden="true">
          <defs>
            <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20"
              patternUnits="userSpaceOnUse">
              <rect x="0" y="0" width="4" height="4" class="text-gray-200 dark:text-gray-700" fill="currentColor">
              </rect>
            </pattern>
          </defs>
          <rect width="100" height="450" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)"></rect>
        </svg>
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 md:text-2xl lg:text-3xl">Journal your trade
        </h2>
        <p class="font-normal dark:text-gray-400">
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
        <svg class="absolute left-0 hidden lg:block" width="100" height="450" fill="none" viewBox="0 0 100 450"
          aria-hidden="true">
          <defs>
            <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20"
              patternUnits="userSpaceOnUse">
              <rect x="0" y="0" width="4" height="4" class="text-gray-200 dark:text-gray-700" fill="currentColor">
              </rect>
            </pattern>
          </defs>
          <rect width="100" height="450" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)"></rect>
        </svg>
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 md:text-2xl lg:text-3xl">Improve</h2>
        <p class="font-normal dark:text-gray-400">
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
    class="px-4 py-16 bg-gradient-to-r from-primary-700 via-primary-600 to-primary-700 dark:from-dark-300 dark:to-dark-300">
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
          <p class="text-sm font-normal text-white dark:text-gray-400">
            Provide user friendly UI and UX which makes you enjoy the process of journaling your trade.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.chart-pie />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Chart
          </h3>
          <p class="text-sm font-normal text-white dark:text-gray-400">
            Chart is used to provide you easy visualization of your trading performance.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.currency-dollar />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Currency
          </h3>
          <p class="text-sm font-normal text-white dark:text-gray-400">
            Customizable currency make {{ ucfirst(config('app.name')) }} works with most of the currency available in
            the world.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.duplicate />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Portfolio
          </h3>
          <p class="text-sm font-normal text-white dark:text-gray-400">
            Ability to create multiple portfolio which is useful to seperate your trading based
            on different instrument or currency.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.cloud />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Cloud
          </h3>
          <p class="text-sm font-normal text-white dark:text-gray-400">
            The server were hosted in cloud service provider for better availability and security.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.qrcode />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg">
            Authentication
          </h3>
          <p class="text-sm font-normal text-white dark:text-gray-400">
            Further secure your account by enabling two factor authentication with Google Authenticator.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 mb-1 text-white rounded-lg shadow-md dark:text-gray-200 bg-primary-500">
            <x-icon.moon />
          </div>
          <h3 class="font-medium text-white dark:text-gray-200 lg:text-lg ">
            Dark Mode
          </h3>
          <p class="text-sm font-normal text-white dark:text-gray-400">
            Available in dark and light mode, switch mode depending on your personal preferences.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="">
    <div class="flex flex-col px-4 py-8 mx-auto lg:flex-row max-w-7xl md:py-24">
      <div class="flex flex-col items-start justify-center flex-1">
        <h2 class="text-xl font-semibold text-gray-700 md:text-2xl lg:text-3xl dark:text-gray-200">Works with different
          kinds of trading instrument</h2>
        <p class="text-lg dark:text-gray-400">
          {{ config('app.name') }} support wide range of market and currency.
        </p>
      </div>
      <div class="flex flex-wrap justify-center flex-1 space-x-2 space-y-2 text-gray-700 dark:text-gray-200">
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

  <div class="px-4 py-8 text-gray-700 dark:text-gray-200" id="pricing">
    <div class="flex flex-col mx-auto space-y-4 max-w-7xl">
      <h2 class="text-xl font-semibold md:text-center md:text-2xl lg:text-3xl">Pricing</h2>
      <div class="grid w-full max-w-5xl grid-cols-1 gap-10 mx-auto md:grid-cols-2 lg:grid-cols-3">
        @foreach ($packages as $package)
          @if ($package->price >= 1)
            <x-ui.card class="flex flex-col items-start p-6 ">
              <div class="pb-8">
                <h2 class="text-xl font-semibold lg:text-2xl text-primary-500">{{ $package->name }}</h2>
                <p class="text-sm font-normal dark:text-gray-400">{!! $package->description !!}</p>
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
                <p class="text-sm font-normal dark:text-gray-400">{!! $package->description !!}</p>
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

  <div class="px-4 pt-16 pb-16 text-gray-700 dark:text-gray-200" id="faq">

    <div class="flex flex-col mx-auto space-y-4 max-w-7xl">
      <h2 class="text-xl font-semibold md:text-center md:text-2xl lg:text-3xl">Frequently Asked Questions</h2>
      <div class="mx-auto" x-data="{selected:1}">
        <ul class="flex flex-col w-full max-w-4xl space-y-4">
          @foreach ($faqs as $index => $faq)
            <li class="relative border border-gray-200 dark:border-gray-600 dark:text-gray-400">
              <button type="button" class="w-full px-3 py-2 text-left focus:outline-none "
                x-on:click="selected !== {{ $index + 1 }} ? selected = {{ $index + 1 }} : selected = null">
                <div class="flex items-center justify-between ">
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
