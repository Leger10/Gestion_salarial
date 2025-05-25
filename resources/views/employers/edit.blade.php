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

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h3 class="card-title text-center" >Modifier  les informations sur l'Employé</h3> <!-- Titre centré -->
            <form action="{{ route('employers.update', $employer->id) }}" method="POST">
                @csrf
                @method('PUT')
    
                <div class="mb-3">
                   <b> <label for="nom" class="form-label" style="color: green">Nom</label> </b>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $employer->nom) }}" required>
                </div>
                
                <div class="mb-3">
                      <b><label for="prenom" class="form-label" style="color: green">Prénom</label></b>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $employer->prenom) }}" required>
                </div>
    
                <div class="mb-3">
                      <b><label for="email" class="form-label" style="color: green">Email</label></b>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employer->email) }}" required>
                </div>
    
                <div class="mb-3">
                      <b><label for="phone" class="form-label" style="color: green">Téléphone</label></b>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $employer->phone) }}" required>
                </div>
<div class="mb-3">
    <b><label for="montant_journalier" class="form-label" style="color: green">Montant Journalier</label></b>
    <input type="number" class="form-control @error('montant_journalier') is-invalid @enderror" id="montant_journalier" name="montant_journalier" value="{{ old('montant_journalier', $employer->montant_journalier) }}" required step="0.01" min="0">
    @error('montant_journalier')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <b><label for="heures_travail" class="form-label" style="color: green">Heures de travail par jour</label></b>
    <input type="number" class="form-control @error('heures_travail') is-invalid @enderror" id="heures_travail" name="heures_travail" value="{{ old('heures_travail', $employer->heures_travail) }}" required>
    @error('heures_travail')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


    
                <div class="mb-3">
                      <b><label for="departement_id" class="form-label" style="color: green">Département</label></b>
                    <select class="form-control" id="departement_id" name="departement_id" required>
                        @foreach ($departements as $departement)
                            <option value="{{ $departement->id }}" {{ $employer->departement_id == $departement->id ? 'selected' : '' }}>
                                {{ $departement->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
               
                <div class="d-flex justify-content-between"> <!-- Flexbox pour espacer les boutons -->
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('employers.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
    
@endsection
