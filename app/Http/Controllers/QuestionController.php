<?php

namespace App\Http\Controllers;

use File;
use App\Theme;
use App\Answer;
use App\Question;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use Intervention\Image\ImageManagerStatic as Image;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $question = new Question;

        return view('admin.questions.create', compact('question'));
    }

    public function store(QuestionRequest $request)
    {
        $question = Question::create($request->all());
        $this->multiple_answers($request, $question->id);
        $this->uploadImage($request, $question);

        return redirect('questions')->with('message', 'Question ajoutée avec succès !');
    }

    public function byTheme($slug)
    {
        $theme = Theme::where('slug', $slug)->firstOrFail();
        $questions = Question::where('theme_id', $theme->id)->get();

        return view('admin.questions.index', compact('questions'));
    }

    public function show($id)
    {
        abort(404, 'Sorry');
    }

    public function edit($id)
    {
        $question = Question::find($id);

        return view('admin.questions.edit', compact('question'));
    }

    public function update(QuestionRequest $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        $this->multiple_answers($request, $id);
        $this->uploadImage($request, $question);
        $this->deleteImage($request, $question);

        return redirect('questions')->with('message', 'Question modifiée avec succès !');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        if ($question->picture) {
            $fileName = env('UPLOAD_IMAGES', 'uploads') . DIRECTORY_SEPARATOR . $question->picture;
            if (File::exists($fileName))
                File::delete($fileName);
        }

        $question->delete();

        return back();
    }

    public function addAnswer()
    {
        $answer = Answer::create();

        return $answer->id;
    }

    public function deleteAnswer($id)
    {
        Answer::findOrFail($id)->delete();
    }

    private function multiple_answers($request, $question_id)
    {
        if ($answers = $request->get('multiple_answer')) {
            foreach ($answers as $key => $answer) {
                $a = Answer::findOrFail($request->get('id_multiple_answer')[$key]);
                if (empty($answer))
                    $a->delete();
                else {
                    $a->answer = $answer;
                    $a->question_id = $question_id;
                    $a->touch();
                }
            }
        }
    }

    private function deleteImage($request, Question $question)
    {
        if (!empty($request->input('deleteImage'))) {
            $fileName = env('UPLOAD_IMAGES', 'uploads') . DIRECTORY_SEPARATOR . $question->picture;
            $question->picture = null;
            $question->touch();

            if (File::exists($fileName))
                File::delete($fileName);
        }
    }

    private function uploadImage($request, Question $question)
    {
        if (!empty($request->file('picture'))) {
            if ($question->picture)
                $this->deleteImage($request, $question);

            $img = $request->file('picture');
            $ext = $img->getClientOriginalExtension();
            $uri = str_random(50) . '.' . $ext;
            $question->picture = $uri;
            $question->touch();
            $img->move(env('UPLOAD_IMAGES', 'uploads'), $uri);

            // BUG SUR MOBILE avec l'upload de photo direct
            /*$imgResize = Image::make(env('UPLOAD_IMAGES', 'uploads') . DIRECTORY_SEPARATOR . $uri);
            $imgResize->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imgResize->save(env('UPLOAD_IMAGES', 'uploads') . DIRECTORY_SEPARATOR . $uri);*/
        }
    }
}
