@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
                    <span>{{ __('Tableau de bord Super Administrateur') }}</span>

                    <!-- Bouton Déconnexion -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            Déconnexion
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p>
                        Bienvenue, <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong> !<br>
                        Vous êtes connecté en tant que <strong>{{ Auth::user()->getRoleName() }}</strong>.
                    </p>

                    <hr>

                    <h5 class="mb-3">Liste des Super Administrateurs</h5>
                    <ul class="list-group">
                        @forelse($superadmins as $admin)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $admin->prenom }} {{ $admin->nom }} 
                                <span class="text-muted">{{ $admin->email }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucun super administrateur trouvé.</li>
                        @endforelse
                    </ul>

                    <!-- Bouton retour au dashboard principal -->
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4">
                        ← Accéder au dashboard principal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
