<?php

namespace App\Services;

use Auth;
use App\Answer;
use App\Result;
use App\Question;
use App\Http\Helpers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestionsService
{
    public static function checkAnswer($request, $question, $maxQuestion = null, $score = null)
    {
        $success = sprintf('Bravo, la réponse à la question «%s» était bien «%s» !', $question->question, $question->answer);
        $fail = sprintf('Dommage, la réponse à la question  «%s» était «%s» !', $question->question, $question->answer);

        if (Helpers::clean($question->answer) === Helpers::clean($request->get('answer'))) {
            Session::put('score', Session::get('score') + 1);
            if ($maxQuestion)
                return view('front.result', compact('score', 'maxQuestion'))->with('messageSuccess', $success);

            return back()->with('messageSuccess', $success);

        }

        if ($maxQuestion)
            return view('front.result', compact('score', 'maxQuestion'))->with('messageFail', $fail);

        return back()->with('messageFail', $fail);

    }

    public static function checkAnswerMultiple($request, $question, $maxQuestion = null, $score = null)
    {
        $nbAnswers = Answer::where('question_id', $question->id)->count();
        $goodAnswers = 0;
        $status = array();
        $answers = array();

        if (is_array($request->get('answer'))) {
            foreach ($question->answers as $key => $answer) {
                $status[$key] = false;
                foreach ($request->get('answer') as $ourAnswer) {
                    if (Helpers::clean($answer->answer) === Helpers::clean($ourAnswer)) {
                        Session::put('score', Session::get('score') + (1 / $nbAnswers));
                        $goodAnswers++;
                        $status[$key] = true;
                    }
                }
            }
        }

        foreach ($question->answers as $answer) {
            $answers[] = $answer->answer;
        }


        if ($maxQuestion)
            return view('front.result', compact('score', 'maxQuestion'))
                ->with('messageMultiple', ['status' => $status, 'answers' => $answers, 'nbAnswers' => $nbAnswers])
                ->with('messageGood', $goodAnswers);
        else
            return back()
                ->with('messageMultiple', ['status' => $status, 'answers' => $answers, 'nbAnswers' => $nbAnswers])
                ->with('messageGood', $goodAnswers);

    }

    public static function getResult(Request $request, $maxQuestion, $theme, $score)
    {
        $lastQuestion = Question::findOrFail(Session::get('questions')[$maxQuestion - 1]);
        Result::create([
            'score' => $score,
            'user_id' => Auth::user()->id,
            'theme_id' => $theme,
        ]);

        Session::forget('score');
        Session::forget('questions');

        if ($lastQuestion->multiple())
            return QuestionsService::checkAnswerMultiple($request, $lastQuestion, $maxQuestion, $score);

        return QuestionsService::checkAnswer($request, $lastQuestion, $maxQuestion, $score);
    }

    public static function getRandomQuestion($theme, $total, $maxQuestion, $score)
    {
        $prevQuestions = Session::get('questions');
        $questions = Question::with('answers', 'type', 'theme')
            ->whereNotIn('id', $prevQuestions)
            ->where('theme_id', $theme)
            ->get();
        $nbQuestions = $questions->count();
        $randomQuestion = $questions[rand(0, $nbQuestions - 1)];
        $remainingQuestions = $maxQuestion - $total;

        return view('front.index', compact('randomQuestion', 'score', 'maxQuestion', 'remainingQuestions'));
    }

}