@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Choisis ton thème</h2>

                @foreach($themes as $theme)
                    @if($theme->questions->count())
                        <div class="theme">
                            <a style="display: block" href="{{ action('FrontController@index', $theme->slug)}}"
                               class="btn btn-primary">{{ $theme->name }}<br/>({{ $theme->questions->count()}}
                                questions)</a>
                        </div>
                    @endif
                @endforeach
                <div class="theme">
                    <a style="display: block" href="{{ action('FrontController@index', 'aleatoire')}}"
                       class="btn btn-warning">Aléatoire<br/>(20 questions)</a>
                </div>
            </div>
        </div>
    </div>
@endsection