@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Quizz</h2>
                @if( session()->has('messageSuccess'))
                    <div class="alert alert-success" role="alert">{{ session()->get('messageSuccess') }}</div>
                @elseif(session()->has('messageFail'))
                    <div class="alert alert-danger" role="alert">{{ session()->get('messageFail') }}</div>
                @endif

                @if( session()->has('messageSuccessMultiple'))
                    <div class="alert alert-success">
                        Bravo, toutes les réponses sont exactes, les réponses étaient bien :
                        <ul>
                            @foreach(session()->get('messageSuccessMultiple') as $success)
                                <li>{{ $success->answer }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(session()->has('messageFailMultiple'))
                    <div class="alert alert-danger">
                        Dommage vous avez trouvé {{ session()->get('messageGood') }} bonne(s) réponse(s), les réponses
                        étaient
                        donc :
                        <ul>
                            @foreach(session()->get('messageFailMultiple') as $fail)
                                <li>{{ $fail->answer }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p class="question">{{ $randomQuestion->question }}</p>
                @if($randomQuestion->picture)
                    <div>
                        <img src="{{ $randomQuestion->uriPicture()}}" alt="" class="img-responsive"
                             style="max-width: 300px; max-height: 300px; display: block; margin: 5px auto;">
                    </div>
                @endif
            </div>
            @if($randomQuestion->type->name === 'qcm')

                <form action="{{ action('FrontController@answer', $randomQuestion->id) }}" method="POST"
                      class="col-xs-12">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="td">
                            <div class="radio col-xs-6">
                                <label>
                                    <input type="radio" name="answer" value="{{ $randomQuestion->qcm_answer_1 }}">
                                    {{ $randomQuestion->qcm_answer_1 }}
                                </label>
                            </div>
                            <div class="radio  col-xs-6">
                                <label>
                                    <input type="radio" name="answer" value="{{ $randomQuestion->qcm_answer_2 }}">
                                    {{ $randomQuestion->qcm_answer_2 }}
                                </label>
                            </div>
                            <div class="radio  col-xs-6">
                                <label>
                                    <input type="radio" name="answer" value="{{ $randomQuestion->qcm_answer_3 }}">
                                    {{ $randomQuestion->qcm_answer_3 }}
                                </label>
                            </div>
                            <div class="radio col-xs-6">
                                <label>
                                    <input type="radio" name="answer" value="{{ $randomQuestion->qcm_answer_4 }}">
                                    {{ $randomQuestion->qcm_answer_4 }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Valider" class="btn btn-primary">
                </form>
            @elseif($randomQuestion->type->name === 'multiple réponses')
                <form action="{{ action('FrontController@multipleAnswers', $randomQuestion->id) }}" method="POST"
                      class="col-xs-12">
                    {{ csrf_field() }}
                    @foreach(App\Answer::where('question_id', $randomQuestion->id)->get() as $answer)
                        <div class="form-group">
                            <input type="text" name="answer[]" class="form-control" placeholder="Votre réponse"
                                   autocomplete="off">
                        </div>
                    @endforeach
                    <input type="submit" value="Valider" class="btn btn-primary">
                </form>
            @else
                <form action="{{ action('FrontController@answer', $randomQuestion->id) }}" method="POST"
                      class="col-xs-12">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="answer" class="form-control" placeholder="Votre réponse"
                               autocomplete="off">
                    </div>
                    <input type="submit" value="Valider" class="btn btn-primary">
                </form>
            @endif
        </div>
        <div id="score">{{ Auth::user()->first_name }} ta note est de {{ $score }}/{{ $maxQuestion }}
            <br/>{{ $remainingQuestions }} questions restantes.
        </div>
    </div>
@endsection