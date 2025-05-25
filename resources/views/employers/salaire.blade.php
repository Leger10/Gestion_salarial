@extends('layouts.template')

@section('head') 
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    @php
        $user = auth()->user();
        $userRole = $user->role->name ?? null;
        $isAdmin = in_array($userRole, ['Administrateur', 'Super Administrateur']);
        $isSuperAdmin = ($userRole == 'Super Administrateur');
        $isUser = ($userRole == 'Utilisateur');
    @endphp
@if ($user && in_array($userRole, ['Administrateur', 'Super Administrateur', 'Utilisateur']))
    <!-- CSS Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
@endsection

@section('content') 
<div class="row g-3 mb-4 align-items-center justify-content-between">
    <div class="col-auto">
        <h1 class="app-page-title mb-0">Infos sur Salaire de tous les employés </h1>
    </div>
    <div class="col-auto">
        <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <form action="#orders-all" method="GET" class="col-auto">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un employé">
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
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        @if(session('config'))
            {{ session('config')->type }} - {{ session('config')->value }} 
        @endif
    </div>
@endif

<div class="tab-content" id="orders-table-tab-content">
    <!-- Liste des Employeurs -->
    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table id="salaryTable" class="table app-table-hover mb-0 text-left table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="cell">#</th>
                                <th class="cell" style="color: green">Employés enregistrés</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employers as $employer)
                            <tr>
                                <td class="cell">{{ $loop->iteration }}</td>
                                <td class="cell">{{ $employer->nom }} {{ $employer->prenom }}</td>
                                <td class="cell">
                                    @if ($isAdmin || $isSuperAdmin)
                                        <a href="{{ route('employers.edit', $employer) }}" class="btn btn-warning mb-3">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        
                                    @endif
                                    <a href="{{ route('employers.show1', $employer) }}" class="btn btn-info mb-3">
                                        <i class="fas fa-eye"></i> Voir
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
                    <!-- Pagination -->
                    <div class="pagination justify-content-center">
                        {{ $employers->links() }}
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
                </div>
            </div>
        </div>
    </div>

    <!-- Salaires par Employeur -->
    <div class="tab-pane fade" id="orders-salaries" role="tabpanel" aria-labelledby="orders-salaries-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Salaire (31 jours)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employers as $employer)
                            <tr>
                                <td>{{ $employer->id }}</td>
                                <td>{{ $employer->nom }}</td>
                                <td>{{ $employer->prenom }}</td>
                                <td>{{ number_format($employer->montant_journalier * 31, 0, ',', ' ') }} Fcfa</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Aucun employé trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="pagination justify-content-center">
                        {{ $employers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts') 
    <!-- JS Datatables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#salaryTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Imprimer',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                ]
            });
        });
    </script>
@endsection
