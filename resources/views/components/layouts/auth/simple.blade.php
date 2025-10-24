<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <main class="min-h-screen grid place-items-center p-6">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>

        @livewireScripts
        @fluxScripts
    </body>
</html>