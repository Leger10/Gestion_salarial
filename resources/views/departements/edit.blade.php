@extends('layouts.template')

@section('content') 

    <!-- Afficher le message de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Afficher les erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 settings-section">
        <div class="col-12">
            <b>Modifier le Nom du Département</b>
            <form action="{{ route('departements.update', $departement->id) }}" method="POST">
                @csrf
                @method('PUT')
            
                <div class="mb-3">
                    <label for="nom" class="form-label">Département selectionné</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $departement->nom) }}" required>

                    @error('nom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('departements.index') }}" class="btn btn-secondary">Retour</a>
            </form>
            
        </div>
    </div><!--//row-->

@endsection
