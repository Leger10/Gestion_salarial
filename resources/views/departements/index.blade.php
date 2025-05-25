@extends('layouts.template')

@section('content')
@php
    $user = auth()->user();
    $userRole = $user->role->name ?? null;
    $isAdmin = in_array($userRole, ['Administrateur', 'Super Administrateur']);
    $isSuperAdmin = ($userRole == 'Super Administrateur');
    $isUser = ($userRole == 'Utilisateur');
@endphp

@if ($user && in_array($userRole, ['Administrateur', 'Super Administrateur', 'Utilisateur']))
<div class="row g-3 mb-4 align-items-center justify-content-between">
    <div class="col-auto">
        <h1 class="app-page-title mb-0">Départements</h1>
    </div>
    <!-- Formulaire de recherche -->
    <form action="{{ route('departements.search') }}" method="GET" class="d-flex">
        <div class="col-auto">
            <input type="text" name="query" class="form-control" placeholder="Rechercher un département">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </form>
    
    <!-- Lien pour revenir à la liste complète -->
    @if(request()->has('query'))
        <a href="{{ route('departements.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i></a>
    @endif

    <div class="col-auto ms-auto">  
        @if ($isAdmin || $isSuperAdmin)

        
            <a class="btn app-btn-primary" href="{{ route('departements.export', ['search' => request('search')]) }}">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                </svg>
                Exporter
            </a>
            <a class="btn app-btn-primary" href="{{ route('departements.create') }}">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Ajouter un département
            </a>
        @endif
    </div>
</div><!--//row-->

<nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Tous les Départements</a>
</nav>

<div class="tab-content" id="orders-table-tab-content">
    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">#</th>
                                <th class="cell" style="color: green">Nom Des Départements</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departements as $departement)
                                <tr>
                                    <td class="cell">{{ $departement->id }}</td>
                                    <td class="cell" style="color: green">{{ $departement->nom }}</td>
                                    <td class="cell">
                                        @if ($isAdmin || $isSuperAdmin)
                                        <a href="{{ route('departements.edit', $departement) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> 
                                        </a>
                                        <form action="{{ route('departements.destroy', $departement) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');">
                                                <i class="fas fa-trash-alt"></i> 
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">
                                        Aucun département trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div><!--//table-responsive-->
            </div><!--//app-card-body-->		
        </div><!--//app-card-->
    </div><!--//tab-pane-->
</div><!--//tab-content-->

<nav class="app-pagination">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédente</a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Suivante</a>
        </li>
    </ul>
</nav><!--//app-pagination-->
{{ $departements->links() }}

@endif

@endsection