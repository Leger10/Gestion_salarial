@extends('layouts.app') <!-- ou votre mise en page -->

@section('content')
<div class="container">
    <h1>Mettre à jour la configuration</h1>

    <form action="{{ route('configurations.update', $configuration->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" id="type" class="form-control" value="{{ $configuration->type }}" disabled> <!-- Le type est généralement statique -->
        </div>

        <div class="form-group">
            <label for="value">Valeur</label>
            <input type="text" id="value" name="value" class="form-control" value="{{ $configuration->value }}" required>
            @error('value')
                <div class="alert alert-danger">{{ $message }}</div> <!-- Affichage d'erreurs de validation -->
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('configurations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
