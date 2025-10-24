<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'content' => ['required','string','min:3', 'max:5000'],
        ]);

        Answer::create([
            'content'     => $data['content'],
            'user_id'     => $request->user()->id,
        ]);

        return back()->with('status', 'Comentario publicado.');
    }
}
