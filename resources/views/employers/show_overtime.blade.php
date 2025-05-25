@extends('layouts.template')

@section('content')

<h1>Heure supplémentaire de l'employeur : {{ $employer->name }}</h1>

<p>Date : {{ $overtime->date }}</p>
<p>Heures : {{ $overtime->heures }}</p>
<p>Commentaire : {{ $overtime->commentaire }}</p>

<a href="{{ route('employers.edit_overtime', [$employer->id, $overtime->id]) }}">Modifier</a>

@endsection
