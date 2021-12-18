@section('meta-content')
  <title>{{ ucfirst(config('app.name', 'Laravel')) }} | Edit User</title>
  <meta name="description"
    content="{{ ucfirst(config('app.name', 'Laravel')) }} is an web application to record and track your trading." />
  <meta name="robots" content="noindex, nofollow" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
@endsection
<x-layout.admin>
  <x-slot name="breadcrumbs">
    {{ Breadcrumbs::render('admin.users.edit', $user) }}
  </x-slot>
  <livewire:admin.user.user-form :model="$user" />
</x-layout.admin>
