@extends('layouts.admin')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <a style="margin-bottom: 10px; float: right;" href="{{ action('ThemeController@create') }}" class="btn btn-primary">Nouveau thème</a>

                @if(Session::has('message'))
                    <p>{{Session::get('message')}}</p>
                @endif


                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nom du thème</th>
                        <th colspan="2" width="100">Actions</th>
                    </tr>
                    </thead>
                    @forelse($themes as $theme)
                        <tr>
                            <td>{{ $theme->name }}</td>
                            <td width="50"><a href="{{ action('ThemeController@edit', $theme->id)}}" class="btn btn-success">Modifier</a></td>
                            <td width="50">
                                <form action="{{ action('ThemeController@destroy', $theme->id) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="delete btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                            @empty
                                <p>Aucun thème enregistré</p>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
@endsection