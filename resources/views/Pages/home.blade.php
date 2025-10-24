<x-forum.layouts.home>

  @if (session('status'))
    <div class="max-w-2xl mx-auto my-4 p-4 bg-green-600 text-white text-center rounded-lg shadow">
      {{ session('status') }}
    </div>
  @endif


  @if ($questions->count())
    <ul class="divide-y divide-gray-100">
      @foreach($questions as $question)
        <li class="flex justify-between gap-4 py-4">
          <div class="flex gap-4">
            <div class="size-8 rounded-full flex items-center justify-center"
                 style="background-color: {{ $question->category->color ?? '#999' }};">
              <x-forum.logo class="h-6 text-white" />
            </div>

            <div class="flex-auto">
              <p class="text-sm font-semibold text-gray-900">
                <a href="{{ route('question.show', $question) }}" class="hover:underline">
                  {{ $question->title }}
                </a>
              </p>
              <p class="mt-1 text-xs text-gray-500">{{ $question->user->name }}</p>

              @can('update', $question)
                <div class="mt-2 flex items-center gap-2">
                  <a href="{{ route('questions.edit', $question) }}"
                     class="inline-flex items-center rounded-md border border-gray-300 px-2 py-0.5 text-xs font-medium text-black hover:bg-gray-100">
                    Editar
                  </a>

                  @can('delete', $question)
                    <form method="POST" action="{{ route('questions.destroy', $question) }}"
                          onsubmit="return confirm('¿Eliminar esta pregunta?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center rounded-md border border-red-300 px-2 py-0.5 text-xs font-medium text-red-700 hover:bg-red-50">
                        Eliminar
                      </button>
                    </form>
                  @endcan
                </div>
              @endcan
            </div>
          </div>

          <div class="hidden sm:flex sm:flex-col sm:items-end">
            <p class="text-sm text-gray-900">{{ $question->category->name ?? 'Sin categoría' }}</p>
            <p class="mt-1 text-xs text-gray-500">{{ $question->created_at->diffForHumans() }}</p>
          </div>
        </li>
      @endforeach
    </ul>

    @if ($questions->hasPages())
      <div class="mt-6">
        {{ $questions->onEachSide(1)->links() }}
      </div>
    @endif
  @else
    <p class="text-center text-gray-500 py-10">Aún no hay preguntas.</p>
  @endif

</x-forum.layouts.home>
