<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro de programación</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar superior (déjalo como lo tengas) -->
        <div class="px-4">
            <x-forum.navbar />
        </div>

        <!-- HERO tipo mock -->
        <section class="relative isolate overflow-hidden pt-20 pb-28">
            <!-- Blob/gradiente -->
            <div class="absolute inset-x-0 -z-10 top-[-8rem] blur-3xl" aria-hidden="true">
                <div
                    class="mx-auto aspect-[1155/678] w-[72rem] -translate-y-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
                    style="clip-path: polygon(74.1% 44.1%,100% 61.6%,97.5% 26.9%,85.5% .1%,80.7% 2%,72.5% 32.5%,60.2% 62.4%,52.4% 68.1%,47.5% 58.3%,45.2% 34.5%,27.5% 76.7%,.1% 64.9%,17.9% 100%,27.6% 76.8%,76.1% 97.7%,74.1% 44.1%)">
                </div>
            </div>

            <div class="mx-auto max-w-3xl px-4 text-center">
                <!-- Pill superior -->
                <div class="hidden sm:flex sm:justify-center sm:mb-8">
                    <div class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-4 py-2 text-sm text-gray-600">
                        Resuelve tus preguntas de programación.
                        <a href="#" class="font-semibold text-indigo-600">Acerca de &rarr;</a>
                    </div>
                </div>

                <!-- Título enorme en 2 líneas -->
                <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl">
                    <span class="block">Bienvenido a tu foro</span>
                    <span class="block">favorito</span>
                </h1>

                <!-- Subtítulo -->
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Es un espacio para compartir, aprender y crecer en el mundo de la programación.
                    Únete a nuestra comunidad, participa en discusiones y aprende de otros profesionales.
                </p>

                <!-- CTAs (sin “Hola” ni “Salir” dentro del hero) -->
                <div class="mt-10 flex items-center justify-center gap-6">
                    <a href="{{ route('questions.create') }}"
                       class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Preguntar
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900 hover:underline">
                            Login &rarr;
                        </a>
                    @endguest
                </div>
            </div>
        </section>

        <!-- Contenido de cada página (listado, show, etc.) -->
        <main class="mx-auto max-w-4xl px-4 pb-12">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
