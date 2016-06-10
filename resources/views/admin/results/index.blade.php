@extends('layouts.admin')
@section('content')
   
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Score</th>
                        <th>Thème</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    @forelse($results as $result)
                        <tr>
                            <td>{{ $result->user->first_name }}</td>
                            <td>{{ $result->score }}/{{ $result->maxQuestions($result->theme->id) }}</td>
                            <td>{{ ucfirst($result->theme->name) }}</td>
                            <td>{{ $result->date() }}</td>

                            @empty
                                <p>Aucun score enregistré</p>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
@endsection