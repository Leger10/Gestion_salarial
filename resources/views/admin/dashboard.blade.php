@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Tableau de bord Administrateur') }}</span>
                    
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
                        Vous êtes connecté en tant qu'administrateur.
                    </p>
                    <p><strong>Votre rôle :</strong> Administrateur</p>

                    <!-- Bouton retour à la liste des clients -->
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
                        ← Acceder au dasboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
