@props([
    'action',              // route(...) completa
    'label' => 'Eliminar', // texto del botón
    'confirm' => '¿Eliminar esta pregunta?',
])

<div x-data="{ open: false }" class="inline-block">
  <button type="button"
          @click="open = true"
          class="inline-flex items-center rounded-md border border-red-300 px-2 py-0.5 text-xs font-medium text-red-700 hover:bg-red-50">
    {{ $label }}
  </button>

  <div x-show="open" x-cloak class="fixed inset-0 z-40 flex items-center justify-center bg-black/40">
    <div @click.outside="open = false" class="w-full max-w-sm rounded-lg bg-white p-5 shadow">
      <p class="text-sm text-gray-800">{{ $confirm }}</p>

      <div class="mt-4 flex justify-end gap-2">
        <button type="button"
                @click="open = false"
                class="rounded-md border border-gray-300 px-3 py-1 text-sm">
          Cancelar
        </button>

        <form method="POST" action="{{ $action }}">
          @csrf
          @method('DELETE')
          <button class="rounded-md bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-500">
            Eliminar
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
