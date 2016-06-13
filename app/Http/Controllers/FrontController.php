<?php

namespace App\Http\Controllers;

use Auth;
use App\Theme;
use App\Question;
use App\Http\Requests;
use App\Services\QuestionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{

    public $score;

    public function __construct()
    {
        if (!Session::has('questions')) Session::put('questions', array());
        if (!Session::has('score')) Session::put('score', 0);
        $this->score = Session::get('score');
    }

    public function index(Request $request, $theme = null)
    {
        if ($theme === null) {
            $themes = Theme::all();

            return view('front.theme', compact('themes'));
        }

        $total = sizeof(Session::get('questions'));

        if ($theme === 'aleatoire')
            $maxQuestion = 20;
        else {
            $theme = Theme::where('slug', $theme)->first()->id;
            $maxQuestion = Question::where('theme_id', $theme)->get()->count();
        }

        if ($total >= $maxQuestion)
            return QuestionsService::getResult($request, $maxQuestion, $theme, $this->score);

        return QuestionsService::getRandomQuestion($theme, $total, $maxQuestion, $this->score);
    }

    public function answer(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        Session::push('questions', $id);

        if ($question->multiple())
            return QuestionsService::checkAnswerMultiple($request, $question);

        return QuestionsService::checkAnswer($request, $question);
    }

}


