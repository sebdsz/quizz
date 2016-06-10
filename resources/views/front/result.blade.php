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

                @if(session()->has('messageMultiple'))
                    <div class="alert">
                        @if(session()->get('messageGood') === session()->get('messageMultiple')['nbAnswers'])
                            Bravo, vous avez trouvé toutes les bonnes réponses, les
                            réponses
                            étaient
                            bien :
                        @else
                            Dommage, vous avez trouvé {{ session()->get('messageGood') }} bonne(s) réponse(s), les
                            réponses
                            étaient
                            donc :
                        @endif
                        @foreach(session()->get('messageMultiple')['answers'] as $key => $answer)
                            @if(session()->get('messageMultiple')['status'][$key])<p class="alert-success"
                                                                                               style="padding:5px">{{ $answer }}</p>@endif
                            @if(!session()->get('messageMultiple')['status'][$key])<p class="alert-danger"
                                                                                                style="padding:5px">{{ $answer }}</p>@endif
                        @endforeach
                    </div>
                @endif
                <p>Votre score est de {{ $score }}/{{$maxQuestion}}.</p>
                <p>Un autre quizz ?</p>
                <a href="{{ action('FrontController@index') }}" class="btn btn-primary btn-center">Recommencer</a>
            </div>
        </div>
    </div>
@endsection