<x-layout.blank>
  <x-jet-authentication-card>
    <x-slot name="logo">
      {{-- <x-jet-authentication-card-logo /> --}}
      <img class="w-12 h-12 lg:w-16 lg:h-16" src="{{ asset('images/logo.png') }}" alt="logo">
    </x-slot>

    <x-jet-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div>
        <x-jet-label for="name" value="{{ __('Name') }}" />
        <x-jet-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus
          autocomplete="name" />
      </div>

      <div class="mt-4">
        <x-jet-label for="email" value="{{ __('Email') }}" />
        <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
      </div>



      <div class="mt-4">
        <x-jet-label for="phone_number" value="{{ __('Phone Number') }}" />
        <div class="relative flex w-full mt-1">
          <div class="absolute inset-y-0 left-0 flex items-center p-2 overflow-hidden border-r border-gray-300">
            +62</div>
          <x-jet-input id="phone_number" type="number" name="phone_number" class="w-full pl-8 sm:pl-14"
            :value="old('phone_number')" required />
        </div>
      </div>

      <div class="mt-4">
        <x-jet-label for="password" value="{{ __('Password') }}" />
        <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required
          autocomplete="new-password" />
      </div>

      <div class="mt-4">
        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
        <x-jet-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation"
          required autocomplete="new-password" />
      </div>

      @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="mt-4">
          <x-jet-label for="terms">
            <div class="flex items-center">
              <x-jet-checkbox name="terms" id="terms" />

              <div class="ml-2">
                {!! __('I agree to the :terms_of_service and :privacy_policy', [
    'terms_of_service' =>
        '<a target="_blank" href="' .
        route('user.terms.show') .
        '"
                                class="text-sm text-gray-600 underline hover:text-gray-900">' .
        __('Terms of
                                Service') .
        '</a>',
    'privacy_policy' =>
        '<a target="_blank" href="' .
        route('user.policy.show') .
        '"
                                class="text-sm text-gray-600 underline hover:text-gray-900">' .
        __('Privacy
                                Policy') .
        '</a>',
]) !!}
              </div>
            </div>
          </x-jet-label>
        </div>
      @endif

      <div class="flex items-center justify-end mt-4">
        <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
          {{ __('Already registered?') }}
        </a>

        <x-jet-button type="submit" class="ml-4">
          {{ __('Register') }}
        </x-jet-button>
      </div>
    </form>
  </x-jet-authentication-card>
</x-layout.blank>
