@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

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

                <div class="card-header">Formulaire d'enregistrement</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nom"><b>Nom</b></label>
                            <input type="text" name="nom" id="nom" required placeholder="Entrez le nom" class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="prenom"><b>Prénom</b></label>
                            <input type="text" name="prenom" id="prenom" required placeholder="Entrez le prénom" class="form-control @error('prenom') is-invalid @enderror">
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email"><b>Email</b></label>
                            <input type="email" name="email" id="email" required placeholder="Entrez l'email" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ajout du champ de sélection pour le rôle -->
                        <div class="form-group">
                            <label for="role_id"><b>Rôle</b></label>
                            <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un rôle --</option>
                                <option value="1">Administrateur</option>
                                <option value="2">Utilisateur</option>
                                <option value="3">Super Administrateur</option>
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div>
    </div>
</div>
@endsection
