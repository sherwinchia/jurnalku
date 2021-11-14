<x-layout.landing>
  <div class="relative h-screen">
    <div style="background-image: url('{{ asset('images/landing-background.jpg') }}');"
      class="flex flex-col items-center justify-center w-full p-4 mx-auto my-4 overflow-hidden bg-no-repeat bg-cover border rounded-xl max-w-7xl lg:p-0 h-2/3">
      <div class="max-w-4xl p-4 mx-auto my-4 space-y-6 text-center lg:p-0">
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

    <div class="py-6 text-gray-700">
      <div class="flex flex-col mx-auto lg:flex-row max-w-7xl">
        <div class="flex flex-col items-center justify-center flex-1 lg:items-end">
          <h2 class="text-3xl font-semibold">Supported market</h2>
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
  </div>
</x-layout.landing>
