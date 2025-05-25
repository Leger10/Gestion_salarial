@extends('layouts.template')

@section('content')
{{ $admins->links() }}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<div class="row g-3 mb-4 align-items-center justify-content-between">
    <div class="col-auto">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="app-page-title mb-0">Administrateurs</h1>
    </div>
    <div class="col-auto">
        <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <form action="{{ route('admin.search') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un administrateur" style="width: 250px;">
                    
                    <!-- Icône de recherche dans le bouton -->
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="fas fa-search"></i> <!-- Icône de recherche -->
                    </button>
                    
                    <!-- Lien pour revenir à la liste complète avec une icône -->
                    @if(request()->has('search'))
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left"></i> <!-- Icône de retour -->
                        </a>
                    @endif
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
                    <a class="btn app-btn-secondary" href="{{ route('admin.create') }}">
                        Ajouter un administrateur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Liste des administrateurs</a>
</nav>

<div class="tab-content" id="orders-table-tab-content">
    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="cell">#</th>
                                <th class="cell" style="color: green">Nom Complet</th>
                                <th class="cell">Email</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td class="cell">{{ $loop->iteration }}</td>
                                    <td class="cell">{{ $admin->name }}</td> <!-- Assurez-vous d'utiliser 'nom_complet' -->
                                    <td class="cell">{{ $admin->email }}</td>
                                    <td class="cell">
                                       
                                        <a href="{{ route('admin.show', ['id' => $admin->id]) }}" class="btn btn-info mb-3">
                                            <i class="fas fa-eye"></i> 
                                        </a>
                                      
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun administrateur enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                   

                    <!-- Pagination -->
                    <div class="pagination justify-content-center">
                        {{ $admins->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
