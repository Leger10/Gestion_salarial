@extends('layouts.template')
mes
@section('content') 
<!-- resources/views/overtimes/edit.blade.php -->
<h1>Modifier les heures supplémentaires</h1>

<form action="{{ route('employers.show_overtime, [$employer->id, $overtime->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="heures" value="{{ $overtime->heures }}">
    <input type="date" name="date" value="{{ $overtime->date }}">
    <textarea name="commentaire">{{ $overtime->commentaire }}</textarea>

    <button type="submit">Mettre à jour</button>
</form>>
@endsection