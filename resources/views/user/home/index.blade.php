<x-layout.landing>
  <div
    class="relative flex flex-col items-center justify-center w-full mx-auto overflow-hidden border mt-28 rounded-xl max-w-7xl lg:p-0"
    style="height: 60vh;">
    <img src="{{ asset('images/landing-background.jpg') }}" alt="background"
      class="absolute inset-0 z-0 object-cover w-full h-full">
    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-800 to-black opacity-80"></div>
    <div class="z-20 max-w-4xl p-4 mx-auto my-4 space-y-4 text-center lg:p-0">
      <h1 class="text-5xl font-semibold text-white ">The only <span class="text-primary-500">trade journal</span>
        you
        need.</h1>
      <p class="text-lg leading-6 text-gray-300">
        The only trade journal you need to track all of your trading. Simple and intuitive design make it easy for
        newcomer to utilize the platform. {{ config('app.name') }} is suitable for all type of investment.
      </p>
      <x-jet-button class="text-lg">Get Started</x-jet-button>
    </div>
  </div>

  <div class="py-16" style="height: 50vh;">
    <div class="flex flex-col h-full mx-auto lg:flex-row max-w-7xl">
      <div class="flex flex-col items-start justify-center flex-1 pr-20 space-y-4">
        <h2 class="text-3xl font-semibold text-gray-800">Journal your trade</h2>
        <p class="font-normal">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deleniti aspernatur at laudantium sit error iure
          optio dicta, obcaecati eaque laborum doloribus dolore iste. Minima, sit ad soluta ex eum consequuntur?
        </p>
      </div>
      <div class="flex-1">
        <div class="relative h-full overflow-hidden border rounded-lg shadow-lg">
          <img src="{{ asset('images/jurnalku-dashboard.png') }}" alt=""
            class="absolute object-none object-right-top w-full h-full">
        </div>
      </div>
    </div>
  </div>

  <div class="py-16" style="height: 50vh;">
    <div class="flex flex-col h-full mx-auto lg:flex-row-reverse max-w-7xl">
      <div class="flex flex-col items-start justify-center flex-1 pl-20 space-y-4">
        <h2 class="text-3xl font-semibold text-gray-800">Journal your trade</h2>
        <p class="font-normal">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deleniti aspernatur at laudantium sit error iure
          optio dicta, obcaecati eaque laborum doloribus dolore iste. Minima, sit ad soluta ex eum consequuntur?
        </p>
      </div>
      <div class="flex-1">
        <div class="relative h-full overflow-hidden border rounded-lg shadow-lg">
          <img src="{{ asset('images/jurnalku-dashboard.png') }}" alt=""
            class="absolute object-none object-left-top w-full h-full">
        </div>
      </div>
    </div>
  </div>

  <div class="py-16 bg-gradient-to-r from-primary-600 to-primary-700">
    <div class="flex flex-col h-full mx-auto max-w-7xl">
      <h2 class="mb-10 text-3xl font-semibold text-white">Why {{ config('app.name') }}</h2>
      <div class="grid grid-cols-4 gap-10 text-gray-300">
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 rounded-lg shadow-md bg-primary-500">
            <x-icon.cash class="text-white"></x-icon.cash>
          </div>
          <h3 class="text-lg font-medium text-white">
            Simple
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 rounded-lg shadow-md bg-primary-500">

          </div>
          <h3 class="text-lg font-medium text-white">
            Currency
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 rounded-lg shadow-md bg-primary-500">

          </div>
          <h3 class="text-lg font-medium text-white">
            Affordable
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 rounded-lg shadow-md bg-primary-500">

          </div>
          <h3 class="text-lg font-medium text-white">
            Non-subscription
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 rounded-lg shadow-md bg-primary-500">

          </div>
          <h3 class="text-lg font-medium text-white">
            Currency
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 rounded-lg shadow-md bg-primary-500">

          </div>
          <h3 class="text-lg font-medium text-white">
            Portfolio
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
        <div class="flex flex-col space-y-2">
          <div class="w-12 h-12 p-2 rounded-lg shadow-md bg-primary-500">

          </div>
          <h3 class="text-lg font-medium text-white">
            Currency
          </h3>
          <p class="text-sm font-normal">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias sapiente possimus doloremque quas non,
            ducimus temporibus pariatur ipsam debitis eum.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="py-24 text-gray-700">
    <div class="flex flex-col mx-auto max-w-7xl">
      <div class="flex flex-col items-center justify-center flex-1">
        <h2 class="text-3xl font-semibold">Works with different kinds of trading instrument</h2>
        <p class="text-lg leading-6 ">
          {{ config('app.name') }} support wide range of market and currency.
        </p>
      </div>
      <div class="flex flex-wrap justify-center flex-1 space-x-2 space-y-2">
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-32 h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Stocks</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-32 h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Crypto</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-32 h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Forex</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-32 h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Gold</span>
        </div>
        <div class="flex flex-col items-center justify-center p-4">
          <img class="w-32 h-32" src="{{ asset('images/bitcoin.png') }}" alt="icon">
          <span class="text-lg font-medium uppercase">Other</span>
        </div>
      </div>
    </div>
  </div>

  <div class="py-6 text-gray-700 bg-gray-200">
    <div class="flex flex-col mx-auto max-w-7xl">
      <h2 class="text-3xl font-semibold text-center">Pricing</h2>
      <div class="grid w-full max-w-5xl grid-cols-4 gap-10 mx-auto">
        <div class="col-span-2 p-6 border rounded-lg shadow-lg">asd</div>
        <div class="col-span-2 p-6 border rounded-lg shadow-lg">asd</div>
      </div>
    </div>
  </div>
</x-layout.landing>
