<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Theme;
use App\Answer;
use App\Result;
use App\Question;
use App\Http\Helpers;
use App\Http\Requests;
use App\Services\QuestionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        $theme = Theme::where('slug', $theme)->first();
        $theme = $theme->id;

        $maxQuestion = Question::where('theme_id', $theme)->get()->count();

        if ($total >= $maxQuestion)
            return QuestionsService::result($request, $maxQuestion, $theme, $this->score);

        return QuestionsService::getRandomQuestion($theme, $total, $maxQuestion, $this->score);
    }

    public function answer(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        Session::push('questions', $id);

        return QuestionsService::checkAnswer($request, $question);
    }

    public function multipleAnswers(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        Session::push('questions', $id);

        return QuestionsService::checkAnswerMultiple($request, $question);
    }



}


