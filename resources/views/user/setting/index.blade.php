@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | Settings</title>
  <meta name="description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta name="robots" content="noindex, nofollow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
@endsection
<x-layout.user header="Settings">
  <livewire:user.setting.setting-form />
</x-layout.user>
