@extends('layouts.template')

@section('content')
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Ajouter un Administrateur</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-4">
                <h3 class="section-title" style="color: green">Ajout</h3>
                <div class="section-intro">Ajouter un nouvel administrateur</div>
            </div>

            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form action="{{ route('admin.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="nom_complet">Nom complet</label>
                                <input type="text" name="nom_complet" class="form-control" value="{{ old('nom_complet') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Créer administrateur</button>
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Retour</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
