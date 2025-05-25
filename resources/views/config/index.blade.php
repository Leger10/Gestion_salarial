@extends('layouts.template')

@section('content')
<div class="row g-3 mb-4 align-items-center justify-content-between">
    <div class="col-auto">
        <h1 class="app-page-title mb-0">Configurations</h1>
    </div>
    <div class="col-auto">
        <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <form action="{{ route('departements.search') }}" method="GET">
                    <div class="col-auto">
                        <!-- Ajoutez un champ de recherche ici si nécessaire -->
                    </div>
                </form>
                <div class="col-auto">
                    <select class="form-select w-auto">
                        <option selected value="option-1">Total</option>
                        <option value="option-2">Cette Semaine</option>
                        <option value="option-3">Ce Mois</option>
                        <option value="option-4">Les 3 Derniers Mois</option>
                        <option value="option-5">Les 6 Derniers Mois</option>
                    </select>
                </div>
                <div class="col-auto">
                    <a class="btn btn-secondary d-inline-flex align-items-center" href="{{ route('configurations.create') }}">
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                       
                    </a>
                    
                </div>
            </div><!--//row-->
        </div><!--//table-utilities-->
    </div><!--//col-auto-->
</div><!--//row-->

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        @if(session('config'))
            {{ session('config')->type }} - {{ session('config')->value }} 
        @endif
    </div>
@endif

<nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Toutes les Configurations</a>
</nav>

<div class="tab-content" id="orders-table-tab-content">
    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table mb-0 text-left">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Valeur</th>
                                <th>Logo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allConfigurations as $index => $configuration)
                            <tr>
                                <td>{{ $index + 1 }}</td> <!-- Affichage d'un numéro séquentiel -->
                                <td>
                                    @switch($configuration->type)
                                        @case('PAYMENT_DATE')
                                            <span class="payment-date-message" style="color: rgb(235, 13, 13)">Date mensuelle de paiement le</span>
                                            @break
                                        @case('APP_NAME')
                                            <span class="app-name-message" style="color: blue">Nom de l'application :</span>
                                            @break
                                        @case('DEVELOPPER_NAME')
                                            <span class="developer-name-message" style="color: green">Équipe de développement :</span>
                                            @break
                                        @case('WORKING_HOURS')
                                            <span class="working-hours-message" style="color: orange">Heures de travail :</span>
                                            @break
                                        @case('ANOTHER')
                                            <span class="another-message" style="color: purple">Autres options :</span>
                                            @break
                                        @default
                                            {{ $configuration->type }}
                                    @endswitch
                                </td>
                                <td>
                                    {{ $configuration->value }} <!-- Affichage de la valeur -->
                                    @switch($configuration->type)
                                        @case('PAYMENT_DATE')
                                            <span class="payment-date-message" style="color: rgb(235, 13, 13)">de chaque mois</span>
                                            @break
                                        @case('APP_NAME')
                                            <span class="app-name-message" style="color: blue"></span>
                                            @break
                                        @case('DEVELOPPER_NAME')
                                            <span class="developer-name-message" style="color: green"></span>
                                            @break
                                        @case('WORKING_HOURS')
                                            <span class="working-hours-message" style="color: orange"></span>
                                            @break
                                        @case('ANOTHER')
                                            <span class="another-message" style="color: purple"></span>
                                            @break
                                        @default
                                            {{ $configuration->value }}
                                    @endswitch
                                </td>
                                <td>
                                    @if($configuration->logo)
                                        <img src="{{ asset('storage/' . $configuration->logo) }}" alt="Logo" style="width: 50px; height: auto;">
                                    @else
                                        Aucune image
                                    @endif
                                </td> <!-- Affichage du logo -->
                                <td>
                                    <b>
                                        @if($configuration->created_at)
                                            {{ $configuration->created_at->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </b> <!-- Date de création formatée -->
                                </td>
                                <td>
                                    <form action="{{ route('configurations.delete', $configuration->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette configuration ?');">
                                            <i class="fas fa-trash me-1"></i> 
                                        </button>
                                        
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>

                    <!-- Pagination -->
                    {{ $allConfigurations->links() }}
                </div><!--//table-responsive-->
            </div><!--//app-card-body-->
        </div><!--//app-card-->
    </div><!--//tab-pane-->
</div><!--//tab-content-->
@endsection
