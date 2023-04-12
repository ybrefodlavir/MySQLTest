<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $last_question = Answer::where([['student_id', 1], ['status', 1]])->latest()->first();
        if ($last_question == null) {
            $question = Question::first();
        } else {
            $question = Question::where('id', '>', $last_question->question_id)->orderBy('id', 'asc')->first();
        }

        return view('welcome', ['question' => $question]);
    }
}
