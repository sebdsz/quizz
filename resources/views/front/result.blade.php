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
                        @foreach(session()->get('messageSuccessMultiple') as $success)
                            <p>{{ $success->answer }}</p>
                        @endforeach
                    </div>
                @elseif(session()->has('messageFailMultiple'))
                    <div class="alert">
                        Dommage vous avez trouvé {{ session()->get('messageGood') }} bonne(s) réponse(s), les réponses
                        étaient
                        donc :
                        @foreach(array_combine(session()->get('messageFailMultiple')['status'], session()->get('messageFailMultiple')['answers']) as $status => $answer)
                            @if($status)<p class="alert-success" style="padding:5px">{{ $answer }}</p>@endif
                            @if(!$status)<p class="alert-danger" style="padding:5px">{{ $answer }}</p>@endif
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