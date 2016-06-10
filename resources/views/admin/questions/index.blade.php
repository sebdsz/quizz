@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-xs-12">

            <div class="row" style="margin-bottom:20px;">
                <div class="col-xs-12">
                    Trier les questions par thème :
                    @foreach(App\Theme::all() as $theme)
                    <a class="btn btn-default"
                       href="{{ action('QuestionController@byTheme', $theme->slug) }}">{{ $theme->name }}</a>
                    @endforeach
                    <a style="margin-bottom: 10px; float:right;" href="{{ action('QuestionController@create') }}"
                       class="btn btn-primary">Nouvelle
                        question</a>
                </div>

            </div>


            @if(Session::has('message'))
            <p>{{Session::get('message')}}</p>
            @endif

            @if(Session::has('messageError'))
            <div class="alert alert-danger" role="alert">{{Session::get('messageError')}}</div>
            @endif

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Question</th>
                    <th>Réponse</th>
                    <th>Type de question</th>
                    <th>Thème de la question</th>
                    <th>Visuel de la question</th>
                    <th colspan="2" width="100">Actions</th>
                </tr>
                </thead>
                @forelse($questions as $question)
                <tr>
                    <td>{{ $question->question }}</td>
                    <td>{{ $question->answer }}</td>
                    <td>{{ ucfirst($question->type->name) }}</td>
                    <td>@if($theme = $question->theme) {{ ucfirst($theme->name) }} @endif</td>
                    <td>@if($question->picture) <img src="{{ $question->uriPicture() }}" class="img-responsive"
                                                     style="max-width: 250px; max-height:200px"> @endif
                    </td>
                    <td width="50"><a href="{{ action('QuestionController@edit', $question->id)}}"
                                      class="btn btn-success">Modifier</a>
                    </td>
                    <td width="50">
                        <form action="{{ action('QuestionController@destroy', $question->id) }}" method="post">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="delete btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                    @empty
                    <p>Aucune question</p>
                </tr>
                @endforelse
            </table>
        </div>
    </div>
</div>
@endsection