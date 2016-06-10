@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Quizz SUGE</h2>
                @if( session()->has('messageSuccess'))
                    <div class="alert alert-success" role="alert">{{ session()->get('messageSuccess') }}</div>
                @elseif(session()->has('messageFail'))
                    <div class="alert alert-danger" role="alert">{{ session()->get('messageFail') }}</div>
                @endif
                <p>Votre score est de {{ $score }}/{{$maxQuestion}}.</p>
                <p>Un autre quizz ?</p>
                <a href="{{ action('FrontController@index') }}" class="btn btn-primary btn-center">Recommencer</a>
            </div>
        </div>
    </div>
@endsection