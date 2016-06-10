@extends('layouts.admin')

@section('content')

    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <strong>Cool !</strong> {{ Session::get('message') }}
            </div>
        @endif

        <form action="{{ action('QuestionController@update', $question->id) }}" method="POST"
              enctype="multipart/form-data">
            {{ method_field('PUT') }}
            {{ csrf_field() }}


            <div class="form-group">
                <label for="question" class="form-label">Question</label>
                <textarea class="form-control" name="question" id="question"
                          placeholder="Votre question">{{ $question->question }}</textarea>
                @if($errors->has('question')) <span class="error">{{ $errors->first('question') }}</span> @endif
            </div>
            <div class="form-group">
                <label for="question" class="form-label">Visuel</label>
                <input type="file" name="picture">
                @if($question->picture)
                    <div>
                        <img src="{{ $question->uriPicture() }}" alt="" class="img-responsive" style="max-width: 400px; max-height: 400px">
                    </div>
                    <input type="checkbox" name="deleteImage"> Supprimer l'image
                @endif
                @if($errors->has('picture')) <span class="error">{{ $errors->first('picture') }}</span> @endif
            </div>
            <div class="form-group answer">
                <label for="name" class="form-label">Réponse</label>
                <input type="text" id="answer" name="answer" placeholder="La bonne réponse"
                       value="{{ $question->answer }}"
                       class="form-control">
                @if($errors->has('answer')) <span class="error">{{ $errors->first('answer') }}</span> @endif
            </div>

            <div class="form-group">
                <label for="type_id">Type de question</label>
                <select name="type_id" id="type_id" class="form-control">
                    @foreach(App\Type::lists('name', 'id') as $id => $name)
                        <option value="{{ $id }}"
                                @if($question->type_id == $id) selected @endif>{{ ucfirst($name) }}</option>
                    @endforeach
                </select>
                @if($errors->has('type_id')) <span class="error">{{ $errors->first('type_id') }}</span> @endif
            </div>

            <div class="form-group">
                <label for="theme_id">Thème de la question</label>
                <select name="theme_id" id="theme_id" class="form-control">
                    @foreach(App\Theme::lists('name', 'id') as $id => $name)
                        <option value="{{ $id }}"
                                @if($question->theme_id == $id) selected @endif>{{ ucfirst($name) }}</option>
                    @endforeach
                </select>
                @if($errors->has('theme_id')) <span class="error">{{ $errors->first('theme_id') }}</span> @endif
            </div>

            <div class="form-group qcm">
                <div class="row">
                    <div class="col-md-6">
                        <label for="qcm_answer_1">Réponse QCM 1</label>
                        <input type="text" class="form-control" name="qcm_answer_1"
                               value="{{ $question->qcm_answer_1 }}">
                    </div>
                    <div class="col-md-6">
                        <label for="qcm_answer_2">Réponse QCM 2</label>
                        <input type="text" class="form-control" name="qcm_answer_2"
                               value="{{ $question->qcm_answer_2 }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="qcm_answer_3">Réponse QCM 3</label>
                        <input type="text" class="form-control" name="qcm_answer_3"
                               value="{{ $question->qcm_answer_3 }}">
                    </div>
                    <div class="col-md-6">
                        <label for="qcm_answer_4">Réponse QCM 4</label>
                        <input type="text" class="form-control" name="qcm_answer_4"
                               value="{{ $question->qcm_answer_4 }}">
                    </div>
                </div>
            </div>

            <div class="form-group multiple">
                <div class="row">
                    <div class="col-xs-12">
                        <button id="addAnswer" class="btn btn-default">Ajouter une réponse</button>
                    </div>
                    <div class="answers">
                        @foreach(App\Answer::where('question_id', $question->id)->get() as $answer)
                            <div class="col-xs-12 m_answer">
                                <label for="">Réponse</label>
                                <input type="hidden" value="{{ $answer->id }}" name="id_multiple_answer[]">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="multiple_answer[]"
                                           value="{{ $answer->answer }}">
                                    <span class="input-group-addon deleteAnswer">Supprimer cette réponse</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <input type="submit" value="ok" class="btn btn-primary">
        </form>
    </div>
@endsection