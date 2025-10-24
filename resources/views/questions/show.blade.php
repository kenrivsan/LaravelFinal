<x-forum.layouts.home>
  @if (session('status'))
    <div class="mb-4 rounded-md bg-green-100 px-3 py-2 text-green-800">
      {{ session('status') }}
    </div>
  @endif

  <div class="mb-6">
    <a href="{{ route('home') }}"
       class="inline-flex items-center rounded-md border border-gray-300 px-3 py-2 text-sm font-semibold text-black hover:bg-gray-100">
      ← Volver al home
    </a>
  </div>

  <h1 class="text-2xl font-bold text-gray-900">{{ $question->title }}</h1>

  <p class="mt-1 text-sm text-gray-600">
    {{ $question->user->name }} · {{ $question->created_at->diffForHumans() }} · {{ $question->category->name }}
  </p>

  <div class="mt-4 text-gray-900 whitespace-pre-line">
    {{ $question->content }}
  </div>

  <div class="mt-4 flex gap-2">
    @can('update', $question)
  <div class="pt-4 flex gap-2">
    <a href="{{ route('questions.edit', $question) }}" class="rounded bg-amber-600 px-3 py-1 text-white hover:bg-amber-500">
      Editar
    </a>

    <x-forum.confirm-delete
        :action="route('questions.destroy', $question)"
        label="Eliminar"
        confirm="¿Seguro que deseas borrar esta pregunta? Esta acción no se puede deshacer."
    />
  </div>
@endcan

  </div>

  <hr class="my-6">

  <h2 class="text-lg font-semibold text-gray-900">Comentarios</h2>
  <livewire:comment :commentable="$question" />
</x-forum.layouts.home>
