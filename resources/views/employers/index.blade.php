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
                <!-- Formulaire de recherche amélioré -->
                <form action="{{ route('employers.index') }}" method="GET" class="col-auto d-flex gap-2">
                    <div class="input-group">
                        <input type="text" id="search" name="search" class="form-control" 
                               placeholder="Nom, Prénom ou Référence"
                               value="{{ request('search') }}"
                               aria-label="Recherche">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                    @if(request()->has('search'))
                    <a href="{{ route('employers.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                    @endif
                </form>

                <!-- Filtre par période -->
                <div class="col-auto">
                    <form action="{{ route('employers.index') }}" method="GET">
                        <select class="form-select" name="period">
                            <option value="">Toutes périodes</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Cette Semaine</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Ce Mois</option>
                            <option value="3months" {{ request('period') == '3months' ? 'selected' : '' }}>3 Derniers Mois</option>
                            <option value="6months" {{ request('period') == '6months' ? 'selected' : '' }}>6 Derniers Mois</option>
                        </select>
                        <button type="submit" class="btn btn-link d-none">Filtrer</button>
                    </form>
                </div>

                @if ($isSuperAdmin || $isUser)
                <div class="col-auto">
                    <a class="btn app-btn-primary" href="{{ route('employers.create') }}">
                        <i class="fas fa-plus me-2"></i> Nouvel employé
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="app-card app-card-orders-table shadow-sm mb-5">
    <div class="app-card-body">
        <div class="table-responsive">
            <table class="table app-table-hover mb-0 text-left table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Référence paiement</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employers as $employer)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title bg-light rounded-circle">
                                        {{ strtoupper(substr($employer->prenom, 0, 1)) }}{{ strtoupper(substr($employer->nom, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $employer->prenom }} {{ $employer->nom }}</div>
                                    <div class="text-muted small">Inscrit le {{ $employer->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $employer->email ?? 'N/A' }}</td>
                        <td>{{ $employer->phone ?? 'N/A' }}</td>
                        <td>
                            @if($employer->latestPayment)
                            <span class="badge bg-primary">
                                {{ $employer->latestPayment->reference }}
                            </span>
                            @else
                            <span class="badge bg-secondary">Aucun paiement</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('employers.edit', $employer->id) }}" 
                                   class="btn btn-sm btn-outline-warning"
                                   data-bs-toggle="tooltip"
                                   title="Modifier">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <a href="{{ route('employers.show', $employer->id) }}" 
                                   class="btn btn-sm btn-outline-info"
                                   data-bs-toggle="tooltip"
                                   title="Détails">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('employers.add_overtime', $employer->id) }}" 
                                   class="btn btn-sm btn-outline-primary"
                                   data-bs-toggle="tooltip"
                                   title="Heures supplémentaires">
                                    <i class="fas fa-plus-circle"></i>
                                    <span class="badge bg-info ms-1">
                                        {{ $employer->total_overtime ?? 0 }}h
                                    </span>
                                </a>

                                <a href="{{ route('absences.show', $employer->id) }}" 
                                   class="btn btn-sm btn-outline-success"
                                   data-bs-toggle="tooltip"
                                   title="Absences">
                                    <i class="fas fa-minus-circle"></i>
                                    <span class="badge bg-danger ms-1">
                                        {{ $employer->total_absence_heures }}h
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <div class="text-muted mb-2">Aucun employé trouvé</div>
                                <a href="{{ route('employers.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-1"></i> Ajouter un employé
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($employers->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Affichage de {{ $employers->firstItem() }} à {{ $employers->lastItem() }} sur {{ $employers->total() }} résultats
                </div>
                <div class="pagination justify-content-end">
                    {{ $employers->withQueryString()->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@else
<div class="alert alert-danger">
    <i class="fas fa-lock me-2"></i> Accès restreint - Permissions insuffisantes
</div>
@endif

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activation des tooltips Bootstrap
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    tooltips.forEach(t => new bootstrap.Tooltip(t))
    
    // Gestion automatique des filtres
    document.querySelector('select[name="period"]').addEventListener('change', function() {
        this.closest('form').submit()
    })
})
</script>
@endsection

@endsection