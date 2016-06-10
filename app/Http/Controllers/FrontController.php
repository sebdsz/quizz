<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Theme;
use App\Answer;
use App\Result;
use App\Question;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{

    private function clean($str)
    {
        $str = preg_replace('#Ç#', 'C', $str);
        $str = preg_replace('#ç#', 'c', $str);
        $str = preg_replace('#è|é|ê|ë#', 'e', $str);
        $str = preg_replace('#È|É|Ê|Ë#', 'E', $str);
        $str = preg_replace('#à|á|â|ã|ä|å#', 'a', $str);
        $str = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $str);
        $str = preg_replace('#ì|í|î|ï#', 'i', $str);
        $str = preg_replace('#Ì|Í|Î|Ï#', 'I', $str);
        $str = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $str);
        $str = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $str);
        $str = preg_replace('#ù|ú|û|ü#', 'u', $str);
        $str = preg_replace('#Ù|Ú|Û|Ü#', 'U', $str);
        $str = preg_replace('#ý|ÿ#', 'y', $str);
        $str = preg_replace('#Ý#', 'Y', $str);
        $str = preg_replace('/er/', '', $str);
        $str = preg_replace('/[a-z]{0}Le[\s]+/i', '', $str);
        $str = preg_replace('/[a-z]{0}La[\s]+/i', '', $str);
        $str = str_replace(['.', ','], ['', ''], $str);
        $str = trim(strtolower($str));

        return $str;
    }

    public function index(Request $request, $theme = null)
    {
        //Session::forget('questions');
        //Session::forget('score');

        if ($theme === null) {
            $themes = Theme::all();

            return view('front.theme', compact('themes'));
        }

        if (!Session::has('questions')) Session::put('questions', array());
        if (!Session::has('score')) Session::put('score', 0);

        $score = Session::get('score');
        $total = sizeof(Session::get('questions'));

        $theme = Theme::where('slug', $theme)->first();
        $theme = $theme->id;

        $maxQuestion = Question::where('theme_id', $theme)->get()->count();

        if ($total >= $maxQuestion) {
            $lastQuestion = Question::findOrFail(Session::get('questions')[$maxQuestion - 1]);
            Result::create([
                'score' => $score,
                'user_id' => Auth::user()->id,
                'theme_id' => $theme,
            ]);

            Session::forget('score');
            Session::forget('questions');

            if ($lastQuestion->type->name === 'multiple réponses') return $this->checkAnswerMultiple($request, $lastQuestion, $maxQuestion, $score);

            return $this->checkAnswer($request, $lastQuestion, $maxQuestion, $score);
        }

        $prevQuestions = Session::get('questions');
        $questions = Question::with('answers', 'type', 'theme')->whereNotIn('id', $prevQuestions)->where('theme_id', $theme)->get();
        $nbQuestions = $questions->count();
        $randomQuestion = $questions[rand(0, $nbQuestions - 1)];
        $remainingQuestions = $maxQuestion - $total;

        return view('front.index', compact('randomQuestion', 'score', 'maxQuestion', 'remainingQuestions'));
    }

    public function answer(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        Session::push('questions', $id);

        return $this->checkAnswer($request, $question);
    }

    public function multipleAnswers(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        Session::push('questions', $id);

        return $this->checkAnswerMultiple($request, $question);
    }

    private function checkAnswer($request, $question, $maxQuestion = null, $score = null)
    {
        $success = sprintf('Bravo, la réponse à la question «%s» était bien «%s» !', $question->question, $question->answer);
        $fail = sprintf('Dommage, la réponse à la question  «%s» était «%s» !', $question->question, $question->answer);

        if ($this->clean($question->answer) === $this->clean($request->get('answer'))) {
            Session::put('score', Session::get('score') + 1);
            if ($maxQuestion)
                return view('front.result', compact('score', 'maxQuestion'))->with('messageSuccess', $success);

            return back()->with('messageSuccess', $success);

        } else {
            if ($maxQuestion)
                return view('front.result', compact('score', 'maxQuestion'))->with('messageFail', $fail);

            return back()->with('messageFail', $fail);
        }
    }

    private function checkAnswerMultiple($request, $question, $maxQuestion = null, $score = null)
    {
        $nbAnswers = Answer::where('question_id', $question->id)->count();
        $good = 0;

        foreach ($question->answers as $answer) {
            foreach ($request->get('answer') as $ourAnswer) {
                if ($this->clean($answer->answer) === $this->clean($ourAnswer)) {
                    Session::put('score', Session::get('score') + (1 / $nbAnswers));
                    $good++;
                }
            }
        }

        if ($good == $nbAnswers) {
            if ($maxQuestion) return view('front.result', compact('score', 'maxQuestion'))->with('messageSuccessMultiple', $question->answers)->with('messageGood', $good);
            else return back()->with('messageSuccessMultiple', $question->answers)->with('messageGood', $good);
        } else {
            if ($maxQuestion) return view('front.result', compact('score', 'maxQuestion'))->with('messageFailMultiple', $question->answers)->with('messageGood', $good);
            else return back()->with('messageFailMultiple', $question->answers)->with('messageGood', $good);
        }
    }

}


