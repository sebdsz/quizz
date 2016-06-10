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

    <form action="{{ action('ThemeController@update', $theme->id) }}" method="POST"
          enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}


        <div class="form-group">
            <label for="name" class="form-label">Nom du thème</label>
            <input type="hidden" name="slug">
            <input type="text" id="name" name="name" placeholder="Nom du theme"
                   value="{{ $theme->name }}"
                   class="form-control">
            @if($errors->has('name')) <span class="error">{{ $errors->first('name') }}</span> @endif
        </div>

        <input type="submit" value="ok" class="btn btn-primary">
    </form>
</div>
@endsection