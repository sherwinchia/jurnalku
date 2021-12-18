@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | Terms and Agreement</title>
  <meta name="description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  {{-- <meta property="og:type" content="article" /> --}}
  <meta property="og:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Terms and Agreement" />
  <meta property="og:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta property="og:image" content="{{ asset('images/logo.png') }}" />
  <meta property="og:url" content="{{ route('user.terms.show') }}" />
  <meta property="og:site_name" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Terms and Agreement" />
  <meta name="twitter:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Terms and Agreement">
  <meta name="twitter:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading.">
  <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
  <meta name="twitter:site" content="@sherwin_xnf">
  <meta name="twitter:creator" content="@sherwin_xnf">
@endsection

<x-layout.blank>
  <div class="py-4 ">
    <div class="flex flex-col items-center min-h-screen pt-6 sm:pt-0">
      <div>
        <img class="w-12 h-12 lg:w-16 lg:h-16" src="{{ asset('images/logo.png') }}" alt="logo">
      </div>

      <x-ui.card class="flex flex-col w-full p-4 my-4 space-y-3 sm:max-w-4xl">
        <span>Latest Update: {{ $updated_at }}</span>
        <div class="prose">{!! $terms !!}</div>
      </x-ui.card>
    </div>
  </div>
</x-layout.blank>
