<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Category;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{
    public function show(Question $question)
    {
        $question->load('answers', 'category', 'user');

        return view('questions.show', [
            'question' => $question,
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('questions.create', compact('categories'));
    }

    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $question = Question::create($data);

        return redirect()
            ->route('question.show', $question)
            ->with('status', '¡Pregunta creada correctamente!');
    }

    public function edit(Question $question)
    {
        $this->authorize('update', $question);

        $categories = Category::orderBy('name')->get();

        return view('questions.edit', [
            'question'   => $question,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $this->authorize('update', $question);

        $question->update($request->validated());

        return redirect()
            ->route('question.show', $question)
            ->with('status', '¡Pregunta actualizada correctamente!');
    }

    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->delete();

        return redirect()
            ->route('home')
            ->with('status', 'Pregunta eliminada correctamente.');
    }
}
