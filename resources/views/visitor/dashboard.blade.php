@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Tableau de bord visiteur') }}</span>
                    <!-- Bouton Déconnexion -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            Déconnexion
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <p>
                        Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }} !<br>
                        Vous êtes connecté en tant que visiteur.
                    </p>
                    <p><strong>Votre rôle :</strong> visiteur</p>

                    <!-- Bouton retour à la liste des clients -->
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
                        ← Acceder a votre dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
