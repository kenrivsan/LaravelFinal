<x-forum.layouts.home>
  <h1 class="text-xl font-bold mb-4 text-gray-100">Editar pregunta</h1>

  <form method="POST" action="{{ route('questions.update', $question) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm text-gray-300">Título</label>
      <input type="text" name="title" required
             value="{{ old('title', $question->title) }}"
             class="mt-1 w-full rounded-md bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100">
      @error('title') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-300">Contenido</label>
      <textarea name="content" rows="6" required
                class="mt-1 w-full rounded-md bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100">{{ old('content', $question->content) }}</textarea>
      @error('content') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-300">Categoría</label>
      <select name="category_id" required
              class="mt-1 w-full rounded-md bg-gray-900 border border-gray-700 px-3 py-2 text-gray-100">
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" @selected(old('category_id', $question->category_id) == $cat->id)>{{ $cat->name }}</option>
        @endforeach
      </select>
      @error('category_id') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2 flex items-center gap-3">
      <button type="submit"
              class="rounded-md px-4 py-2 text-black hover:bg-gray-900">
        Actualizar
      </button>
      <a href="{{ route('question.show', $question) }}" class="text-sm underline text-gray-300">Cancelar</a>
    </div>
  </form>
</x-forum.layouts.home>
