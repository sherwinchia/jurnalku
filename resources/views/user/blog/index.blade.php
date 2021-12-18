@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | Blogs</title>
  <meta name="description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta name="robots" content="index, follow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  {{-- <meta property="og:type" content="article" /> --}}
  <meta property="og:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Blogs" />
  <meta property="og:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta property="og:image" content="{{ asset('images/logo.png') }}" />
  <meta property="og:url" content="{{ route('user.blogs.index') }}" />
  <meta property="og:site_name" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Blogs" />
  <meta name="twitter:title" content="{{ ucfirst(config('app.name', 'Laravel')) }} | Blogs">
  <meta name="twitter:description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading.">
  <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
  <meta name="twitter:site" content="@sherwin_xnf">
  <meta name="twitter:creator" content="@sherwin_xnf">
@endsection

<x-layout.landing>
  <livewire:user.blog.blog-index />
</x-layout.landing>
