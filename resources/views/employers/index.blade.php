@extends('layouts.template')

@section('content')
@php
    $user = auth()->user();
    $userRole = $user->role->name ?? null;
    $isAdmin = in_array($userRole, ['Administrateur', 'Super Administrateur']);
    $isSuperAdmin = ($userRole == 'Super Administrateur');
    $isUser = ($userRole == 'Utilisateur');
@endphp

<div class="alert alert-info mb-4">
    <p class="mb-0">Mon rôle est : <strong>{{ $userRole }}</strong></p>
</div>

@if ($user && in_array($userRole, ['Administrateur', 'Super Administrateur', 'Utilisateur']))
<div class="row g-3 mb-4 align-items-center justify-content-between">
    <div class="col-auto">
        <h1 class="app-page-title mb-0">Employés</h1>
    </div>
    
    <div class="col-auto">
        <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <!-- Formulaire de recherche -->
                <form action="{{ route('employers.search') }}" method="GET" class="col-auto d-flex">
                    <div class="input-group">
                        <input type="text" id="search" name="search" class="form-control" 
                               placeholder="Rechercher par nom ou prénom" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        
                        @if(request()->has('search'))
                        <a href="{{ route('employers.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        @endif
                    </div>
                </form>

                <!-- Filtre par période -->
                <div class="col-auto">
                    <form action="{{ route('employers.index') }}" method="GET" class="d-flex">
                        <select class="form-select" name="period" onchange="this.form.submit()">
                            <option value="" {{ !request('period') ? 'selected' : '' }}>Tous</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Cette Semaine</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Ce Mois</option>
                            <option value="3months" {{ request('period') == '3months' ? 'selected' : '' }}>3 Derniers Mois</option>
                            <option value="6months" {{ request('period') == '6months' ? 'selected' : '' }}>6 Derniers Mois</option>
                        </select>
                    </form>
                </div>

                <!-- Bouton Ajouter (visible pour Super Admin et Utilisateur) -->
                @if ($isSuperAdmin || $isUser)
                <div class="col-auto">
                    <a class="btn app-btn-primary" href="{{ route('employers.create') }}">
                        <i class="fas fa-plus me-2"></i> Ajouter un employé
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Le reste de votre contenu (tableau, pagination, etc.) ira ici -->

@else
<div class="alert alert-danger">
    Vous n'avez pas les permissions nécessaires pour accéder à cette page.
</div>
@endif
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all"
        role="tab" aria-controls="orders-all" aria-selected="true">Liste des employés</a>
    <a class="flex-sm-fill text-sm-center nav-link" id="orders-daily-tab" data-bs-toggle="tab" href="#orders-daily"
        role="tab" aria-controls="orders-daily" aria-selected="false">Montant journalier</a>
</nav>

<div class="tab-content" id="orders-table-tab-content">
    <!-- Liste des Employeurs -->
    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="cell">#</th>
                                <th class="cell" style="color: green">Employés enregistrés</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employerResults">
                            @forelse ($employers as $employer)
                                <tr>
                                    <td class="cell">{{ $loop->iteration }}</td>
                                    <td class="cell">{{ $employer->nom }} {{ $employer->prenom }}</td>
                                    <td class="cell">
                                        <a href="{{ route('employers.edit', $employer->id) }}" class="btn btn-warning mb-3">
                                            <i class="fa-solid fa-pen-to-square"></i> 
                                        </a>

                                        <a href="{{ route('employers.show', $employer->id) }}" class="btn btn-info mb-3">
                                            <i class="fas fa-eye"></i> 
                                        </a>

                                        <a href="{{ route('employers.add_overtime', $employer->id) }}" class="btn btn-primary mb-3">
                                            <i class="fas fa-plus"></i>
                                            <i class="fas fa-clock"></i>
                                            <span class="badge bg-info ms-2">
                                                {{ $employer->total_overtime ?? 0 }} h
                                            </span>
                                        </a>

                                        <a href="{{ route('absences.show', $employer->id) }}" class="btn btn-success mb-3">
                                            <i class="fas fa-minus"></i> <i class="fas fa-clock"></i> 
                                            <span class="badge bg-info ms-2">
                                                {{ $employer->total_absence_heures }} h
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Aucun employé trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="pagination justify-content-center mt-3">
                        {{ $employers->links() }}
                    </div>

                    <!-- Total des heures d'absence -->
                    <div class="text-center mt-3">
                        <strong>Total des heures d'absence de tous les employés :</strong>
                        <span class="badge bg-danger ms-2" id="total-absence-badge">{{ $totalAbsenceHeuresAll }} h</span>
                    </div>

                    <!-- Total des heures de travail -->
                    <div class="text-center mt-3">
                        <strong>Total des heures de travail de tous les employés (sur 30 jours) :</strong>
                        <span class="badge bg-info ms-2">{{ $totalHeuresTravailAll }} h</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Montant Journalier -->
    <div class="tab-pane fade" id="orders-daily" role="tabpanel" aria-labelledby="orders-daily-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Montant Journalier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employers as $employer)
                                <tr>
                                    <td>{{ $employer->id }}</td>
                                    <td>{{ $employer->nom }}</td>
                                    <td>{{ $employer->prenom }}</td>
                                    <td>{{ number_format($employer->montant_journalier, 0, ',', ' ') }} Fcfa</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Aucun employé trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="pagination justify-content-center mt-3">
                        {{ $employers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function searchEmployers() {
        let searchQuery = document.getElementById('search').value;

        // Envoi de la requête AJAX
        fetch(`/employers/search?search=${searchQuery}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            // Mise à jour des résultats dans la page
            let resultContainer = document.getElementById('employerResults');
            resultContainer.innerHTML = ''; // Effacer les résultats précédents

            if (data.employers.length > 0) {
                data.employers.forEach(employer => {
                    let employerElement = document.createElement('tr');
                    employerElement.innerHTML = `
                        <td class="cell">${employer.id}</td>
                        <td class="cell">${employer.nom} ${employer.prenom}</td>
                        <td class="cell">
                            <a href="/employers/edit/${employer.id}" class="btn btn-warning mb-3">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="/employers/show/${employer.id}" class="btn btn-info mb-3">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    `;
                    resultContainer.appendChild(employerElement);
                });
            } else {
                resultContainer.innerHTML = '<tr><td colspan="3" class="text-center">Aucun employé trouvé.</td></tr>';
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

@endsection
