@extends('layouts.template')

@section('content')
<style>
    /* Ajouter un fond grisé pour les absences grises */
    .absence-grisee {
        text-decoration: line-through; /* Barrer le texte */
        color: gray; /* Optionnel : changer la couleur pour qu'elle soit grise */
        background-color: #0b3af663; /* Fond gris clair */
        color: #f93d088b; /* Texte légèrement plus sombre pour une meilleure lisibilité */
    }

    /* Ajouter un effet de survol pour les absences grises */
    .absence-grisee:hover {
        background-color: #f7f1f1; /* Fond plus foncé au survol */
    }
</style>
<div class="container-fluid">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: green">
                Absences de {{ $employer->nom }} {{ $employer->prenom }}
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Affichage des heures de travail par jour en rouge -->
        <p><span style="color: red;">Heures de travail par jour : {{ $hoursWorked }} heures</span></p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="tab-content" id="orders-table-tab-content">
        <!-- Liste des absences -->
        <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                    <div class="row">
                        <!-- Formulaire d'ajout d'absence -->
                        <div class="col-12 mb-4">
                            <form action="{{ route('absences.store', $employer->id) }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date d'absence</label>
                                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" required 
                                                   max="{{ \Carbon\Carbon::today()->toDateString() }}">
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="heures">Heures d'absence</label>
                                            <input type="number" name="heures" id="heures" class="form-control @error('heures') is-invalid @enderror" required min="1" max="{{ $hoursWorked }}">
                                            @error('heures')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Ajouter l'absence</button>
                                        <a href="{{ route('employers.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Retour
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau des absences -->
                        <div class="col-12">
                            <h3>Liste des absences</h3>
                            <div class="table-responsive" style="background-color: #f7c6d9; border-radius: 10px;">
                                <table class="table table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th>Date d'absence</th>
                                            <th>Heures d'absence</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($absences as $absence)
                                            <tr>
                                                <td>{{ $absence->date }}</td>
                                                <td class="{{ $absence->is_grayed_out ? 'absence-grisee' : '' }}">{{ $absence->heures }} heures</td>
                                                <td>
    <!-- Formulaire pour Marquer/Dégriser -->
    <td>
    
<!-- Formulaire pour marquer/dégriser une absence avec justification -->
<form action="{{ route('absences.toggleGray', ['employer' => $employer->id, 'absence' => $absence->id]) }}" method="POST" class="gray-out-form">
    @csrf
    @method('PUT')

    <!-- Champ de texte pour la justification avec une ancienne valeur si elle existe -->
    <div class="form-group">
        <label for="note-{{ $absence->id }}">Justification pour {{ $absence->is_grayed_out ? 'dégriser' : 'griser' }} l'absence (obligatoire)</label>
        <textarea name="note" id="note-{{ $absence->id }}" class="form-control @error('note') is-invalid @enderror" rows="2" placeholder="Ajouter une justification..." required>{{ old('note', $absence->note) }}</textarea>

        @error('note')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Bouton de soumission pour griser/dégriser l'absence -->
    <button type="submit" class="btn btn-warning btn-sm mt-2">
        <i class="fas fa-pencil-alt"></i> 
        {{ $absence->is_grayed_out ? 'Dégriser' : 'Marquer comme grisé' }}
    </button>
</form>

</td>



                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

