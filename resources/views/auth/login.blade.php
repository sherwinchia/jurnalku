@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | Login</title>
  <meta name="description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  {{-- <meta property="og:type" content="article" /> --}}
  <meta property="og:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Login" />
  <meta property="og:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta property="og:image" content="{{ asset('images/logo.png') }}" />
  <meta property="og:url" content="{{ route('login') }}" />
  <meta property="og:site_name" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Login" />
  <meta name="twitter:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Login">
  <meta name="twitter:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading.">
  <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
  <meta name="twitter:site" content="@sherwin_xnf">
  <meta name="twitter:creator" content="@sherwin_xnf">
@endsection
<x-layout.blank>
  <x-jet-authentication-card>
    <x-slot name="logo">
      <img class="w-12 h-12 lg:w-16 lg:h-16" src="{{ asset('images/logo.png') }}" alt="logo">
    </x-slot>

    <x-jet-validation-errors class="mb-4" />

    @if (session('status'))
      <div class="mb-4 text-sm font-medium text-green-600">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div>
        <x-jet-label for="email" value="{{ __('Email') }}" />
        <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required
          autofocus />
      </div>

      <div class="mt-4">
        <x-jet-label for="password" value="{{ __('Password') }}" />
        <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required
          autocomplete="current-password" />
      </div>

      <div class="block mt-4">
        <label for="remember_me" class="flex items-center">
          <x-jet-input type="checkbox" id="remember_me" name="remember" />
          <span class="ml-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        @if (Route::has('password.request'))
          <a class="text-sm text-gray-400 underline hover:text-gray-900 dark:hover:text-gray-300"
            href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
          </a>
        @endif

        <x-jet-button type="submit" class="ml-4">
          {{ __('Log in') }}
        </x-jet-button>
      </div>
    </form>
  </x-jet-authentication-card>
</x-layout.blank>
