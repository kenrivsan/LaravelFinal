<x-layouts.auth.simple>
  <div class="flex flex-col gap-6">
    <x-auth-header :title="('Create an account')" :description="('Enter your details below to create your account')" />
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form
      method="POST"
      action="{{ route('register.store') }}"
      class="space-y-4"
      novalidate
      autocomplete="off"
    >
      @csrf

      <flux:input
        name="name"
        :label="('Name')"
        type="text"
        required
        autofocus
        autocomplete="name"
        :placeholder="('Full name')"
        value="{{ old('name') }}"
      />
      @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

      <flux:input
        name="email"
        :label="('Email address')"
        type="email"
        required
        autocomplete="email"
        placeholder="email@example.com"
        value="{{ old('email') }}"
      />
      @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

      <flux:input
        name="password"
        :label="('Password')"
        type="password"
        required
        autocomplete="new-password"
        :placeholder="('Your password')"
      />
      @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

      <flux:input
        name="password_confirmation"
        :label="('Confirm password')"
        type="password"
        required
        autocomplete="new-password"
        :placeholder="('Repeat your password')"
      />
      @error('password_confirmation') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

      <flux:button variant="primary" type="submit" class="w-full">
        {{ __('Sign up') }}
      </flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
      <span>{{ __('Already have an account?') }}</span>
      <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
  </div>
</x-layouts.auth.simple>