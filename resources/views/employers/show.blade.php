@extends('layouts.template')

@section('content')
<div class="app-page-title mb-4">
    <b style="color: green">Détails de l'Employé</b>
</div>

<div class="card shadow-sm p-4" style="background-color: #f7c6d9; border-radius: 10px;">
    <div class="card-body">
        <h3>{{ $employer->nom }} {{ $employer->prenom }}</h3>
        <p><strong>ID :</strong> {{ $employer->id }}</p>
        <p><strong>Email :</strong> {{ $employer->email }}</p>
        <p><strong>Téléphone :</strong> {{ $employer->phone }}</p>
        <p><strong>Département :</strong> {{ $employer->departement->nom }}</p>
        <p><strong>Montant Journalier :</strong> {{ number_format($employer->montant_journalier, 0, ',', ' ') }} Fcfa</p>
        
        <!-- Heures de travail de l'employé -->
        <p><strong>Heures de travail : </strong>{{ $employer->heures_travail }} heures</p>
        
        <!-- Total des heures de travail de l'employé (sur 30 jours) -->
      
             <p><strong>Total heures de travail de l'employé (sur 30 jours) :</strong> </p>
<span class="badge bg-info ms-2">{{ $totalHeuresTravail }} h</span>

        
        <div class="mt-4">
            <form action="{{ route('employers.destroy', $employer) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">Supprimer</button>
            </form>
            <a href="{{ route('employers.index') }}" class="btn btn-secondary">Retour à la liste des employeurs</a>
        </div>
    </div>
</div>

@endsection
