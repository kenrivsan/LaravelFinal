<div class="mx-auto max-w-6xl py-3 px-3 flex items-center justify-between">
  <a href="{{ route('home') }}" class="flex items-center gap-2">
    <x-forum.logo class="h-6" />
    <span class="sr-only">Inicio</span>
  </a>

  <div class="flex items-center gap-4">
    @auth
      <span class="text-sm">Hola, {{ auth()->user()->name }}</span>
      <a href="{{ route('questions.create') }}" class="text-sm rounded bg-indigo-600 px-3 py-1 text-white hover:bg-indigo-500">
        Preguntar
      </a>
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="text-sm underline">Logout</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="text-sm underline">Log in →</a>
      <a href="{{ route('register') }}" class="text-sm underline">Sign up</a>
    @endauth
  </div>
</div>
