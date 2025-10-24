<x-layouts.auth.simple>
  <div class="flex flex-col gap-6">
    <x-auth-header :title="('Log in to your account')" :description="('Enter your email and password below to log in')" />
    <x-auth-session-status class="text-center" :status="session('status')" />

    {{-- IMPORTANTE: method="POST" + action de respaldo --}}
    <form method="POST"
          action="{{ route('login.store') }}"
          wire:submit.prevent="login"
          class="flex flex-col gap-6"
          novalidate
          autocomplete="off">
      @csrf

      <flux:input
        wire:model="email"
        :label="('Email address')"
        type="email"
        required
        autofocus
        autocomplete="email"
        placeholder="email@example.com"
      />
      @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

      <div class="relative">
        <flux:input
          wire:model="password"
          :label="('Password')"
          type="password"
          required
          autocomplete="current-password"
          :placeholder="('Password')"
          viewable
        />
        @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

        @if (Route::has('password.request'))
          <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
            {{ __('Forgot your password?') }}
          </flux:link>
        @endif
      </div>

      <flux:checkbox wire:model="remember" :label="('Remember me')" />

      <div class="flex items-center justify-end">
        <flux:button variant="primary" type="submit" class="w-full" wire:loading.attr="disabled">
          <span wire:loading.remove>{{ __('Log in') }}</span>
          <span wire:loading>{{ __('Signing in...') }}</span>
        </flux:button>
      </div>
    </form>

    @if (Route::has('register'))
      <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('Don\'t have an account?') }}</span>
        <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
      </div>
    @endif
  </div>
</x-layouts.auth.simple>