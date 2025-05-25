@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Salaires</h1>
    <a href="{{ route('salaires.create') }}" class="btn btn-primary mb-3">Ajouter un Salaire</a>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Employeur</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaires as $salaire)
                <tr>
                    <td>{{ $salaire->employer->nom }}</td>
                    <td>{{ $salaire->montant }} €</td>
                    <td>
                        <a href="{{ route('salaires.show', $salaire) }}" class="btn btn-info">Voir</a>
                        <a href="{{ route('salaires.edit', $salaire) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('salaires.destroy', $salaire) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
