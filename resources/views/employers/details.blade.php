@extends('layouts.template')

@section('content') 
<!-- resources/views/employers/show_overtime.blade.php -->

<h1>Détails de l'employeur : {{ $employer->name }}</h1>

<h3>Heures supplémentaires :</h3>
@foreach ($employer->overtimes as $overtime)
    <div>
        <p>{{ $overtime->date }} - {{ $overtime->heures }} heures</p>
        <p>{{ $overtime->commentaire }}</p>
        <a href="{{ route('employers.edit_overtime', [$employer->id, $overtime->id]) }}">Modifier</a>
    </div>
@endforeach

<a href="{{ route('employers.overtimes.store', $employer->id) }}">Ajouter une nouvelle heure supplémentaire</a>

@endsection