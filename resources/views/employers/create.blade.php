@extends('layouts.template')

@section('content') 
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">			    
        <h1 class="app-page-title">Employés</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-4">
                <h3 class="section-title" style="color: green">Ajout</h3>
                <div class="section-intro">Ajouter un nouveau employé</div>
            </div>
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        
                        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form class="settings-form" method="POST" action="{{ route('employers.store') }}">
    @csrf

    <!-- Champ Nom -->
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" placeholder="Entrer le nom de l'employé" name="nom" value="{{ old('nom') }}" required>
        @error('nom')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Champ Prénom -->
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="prenom" placeholder="Entrer le prénom de l'employé" name="prenom" value="{{ old('prenom') }}" required>
        @error('prenom')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Champ Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Entrer l'email de l'employé" name="email" value="{{ old('email') }}" required>
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Champ Téléphone -->
    <div class="mb-3">
        <label for="phone" class="form-label">Téléphone</label>
        <input type="text" class="form-control" id="phone" placeholder="Entrer le téléphone de l'employé" name="phone" value="{{ old('phone') }}" required>
        @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Champ Montant Journalier -->
    <div class="mb-3">
        <label for="montant_journalier" class="form-label">Montant journalier</label>
        <input type="number" class="form-control" id="montant_journalier" placeholder="Entrer le montant journalier de l'employé" name="montant_journalier" value="{{ old('montant_journalier') }}" required>
        @error('montant_journalier')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Champ Heures de travail -->
    <div class="mb-3">
        <label for="heures_travail" class="form-label">Heures de travail par jour</label>
        <input type="number" name="heures_travail"  placeholder="Entrer le nombre d'heures de travail par jour" class="form-control" value="{{ old('heures_travail') }}" required>
        @error('heures_travail')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Sélection du Département -->
    <div class="mb-3">
        <label for="departement_id" class="form-label">Département</label>
        <select class="form-select" id="departement_id" name="departement_id" required>
            <option value="" style="color: red">Sélectionner un département</option>
            @foreach($departements as $departement)
                <option value="{{ $departement->id }}" {{ old('departement_id') == $departement->id ? 'selected' : '' }}>{{ $departement->nom }}</option>
            @endforeach
        </select>
        @error('departement_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Bouton d'enregistrement -->
    <button type="submit" class="btn app-btn-primary">Enregistrer</button>
</form>


                        
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div>
        </div><!--//row-->
    </div>
</div>
@endsection
