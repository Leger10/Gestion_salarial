@extends('layouts.template')

@section('content')
<style>
    /* Ajouter un fond grisé pour les heures supplémentaires grises */
    .absence-grisee {
        text-decoration: line-through; /* Barrer le texte */
        color: gray; /* Optionnel : changer la couleur pour qu'elle soit grise */
        background-color: #0b3af663; /* Fond gris clair */
        color: #f93d088b; /* Texte légèrement plus sombre pour une meilleure lisibilité */
    }

    /* Ajouter un effet de survol pour les heures supplémentaires grises */
    .absence-grisee:hover {
        background-color: #f7f1f1; /* Fond plus foncé au survol */
    }
</style>

<div class="container-fluid">
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0" style="color: green">
                Heures supplémentaires de {{ $employer->nom }} {{ $employer->prenom }}
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
        <!-- Liste des heures supplémentaires -->
        <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                    <div class="row">
                        <!-- Formulaire d'ajout d'heure supplémentaire -->
                        <div class="col-12 mb-4">
                            <form action="{{ route('overtimes.store', ['employerId' => $employer->id]) }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date des heures supplémentaires</label>
                                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" required 
                                                   max="{{ \Carbon\Carbon::today()->toDateString() }}">
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="heures">Heures supplémentaires</label>
                                            <input type="number" name="heures" id="heures" class="form-control @error('heures') is-invalid @enderror" required min="1" max="{{ $hoursWorked }}">
                                            @error('heures')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Ajouter les heures supplémentaires</button>
                                        <a href="{{ route('employers.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Retour
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau des heures supplémentaires -->
                        <div class="col-12">
                            <h3>Liste des heures supplémentaires</h3>
                            <div class="table-responsive" style="background-color: #f7c6d9; border-radius: 10px;">
                                <table class="table table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th>Date des heures supplémentaires</th>
                                            <th>Heures supplémentaires</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($overtimes as $overtime)
                                        <tr>
                                            <td>{{ $overtime->created_at->format('d-m-Y') }}</td>
                                            <td class="{{ $overtime->is_grayed_out ? 'absence-grisee' : '' }}">
                                                <span class="{{ $overtime->is_grayed_out ? 'text-decoration-line-through' : '' }}">
                                                    {{ $overtime->heures }} heures
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('overtimes.toggleGray', ['employerId' => $employer->id, 'overtimeId' => $overtime->id]) }}" method="POST" class="gray-out-form">
                                                    @csrf
                                                    @method('PUT')
                                    
                                                    <div class="form-group">
                                                        <label for="note-{{ $overtime->id }}">Justification pour {{ $overtime->is_grayed_out ? 'dégriser' : 'griser' }} l'heure supplémentaire (obligatoire)</label>
                                                        <textarea name="note" id="note-{{ $overtime->id }}" class="form-control @error('note') is-invalid @enderror" rows="2" placeholder="Ajouter une justification..." required>{{ old('note', $overtime->note) }}</textarea>
                                                        @error('note')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                    
                                                    <button type="submit" class="btn btn-warning btn-sm mt-2">
                                                        <i class="fas fa-pencil-alt"></i> 
                                                        {{ $overtime->is_grayed_out ? 'Dégriser' : 'Marquer comme grisé' }}
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
@endsection
