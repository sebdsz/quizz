@extends('layouts.master')
@section('title', 'Page introuvable.')

@section('content')
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
        html, body {
            height: 100%;
        }

        .title {
            font-size: 72px;
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            font-weight: 100;
            font-family: 'Lato';
            text-align: center;
        }
    </style>
    <div class="title">Erreur 404, <br/>cette page n'existe pas.</div>
@endsection
