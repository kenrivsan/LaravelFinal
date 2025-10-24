<x-forum.layouts.home>
  <h1 class="text-xl font-bold mb-4">Nueva pregunta</h1>

  <form method="POST" action="{{ route('questions.store') }}" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium text-gray-700">Título</label>
      <input
        type="text"
        name="title"
        value="{{ old('title') }}"
        required
        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2"
        placeholder="Escribe un título"
      >
      @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Contenido</label>
      <textarea
        name="content"
        rows="6"
        required
        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2"
        placeholder="Describe tu problema o pregunta…"
      >{{ old('content') }}</textarea>
      @error('content') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Categoría</label>
      <select
        name="category_id"
        required
        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2"
      >
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
        @endforeach
      </select>
      @error('category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="pt-2 flex items-center gap-3">
      <button type="submit"
        class="inline-flex items-center justify-center rounded-md border border-gray-400 bg-white px-4 py-2 text-sm font-semibold text-black hover:bg-gray-100">
        Publicar
      </button>

      <a href="{{ route('home') }}" class="text-sm underline">Cancelar</a>
    </div>
  </form>
</x-forum.layouts.home>
