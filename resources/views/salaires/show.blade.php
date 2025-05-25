@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du Salaire</h1>
    <p><strong>Employeur:</strong> {{ $salaire->employer->nom }}</p>
    <p><strong>Montant:</strong> {{ $salaire->montant }} €</p>
    <a href="{{ route('salaires.index') }}" class="btn btn-secondary">Retour à la liste</a>
</div>
@endsection
