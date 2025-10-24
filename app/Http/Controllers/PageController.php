<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class PageController extends Controller
{
    public function index()
    {
        $questions = \App\Models\Question::query()
            ->with(['user:id,name', 'category:id,name,color'])
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('Pages.home', compact('questions'));
    }


}