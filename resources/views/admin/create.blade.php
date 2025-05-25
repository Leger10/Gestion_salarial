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
        <b><label for="name">Nom de l'Administrateur</label></b>
        <input type="text" name="name" id="name" required placeholder="Entrez le nom complet" class="form-control">
    </div>
    <div class="form-group">
        <b><label for="email">Adresse Email</label></b>
        <input type="email" name="email" id="email" required placeholder="Entrez l'email" class="form-control">
    </div>
    <div class="form-group mt-3">
        <b><label for="role_id">Rôle</label></b>
        <select name="role_id" id="role_id" class="form-control" required>
            <option value="">-- Sélectionnez un rôle --</option>
            <option value="1">Administrateur</option>
            <option value="2">Utilisateur</option>
            <option value="3">Super Administrateur</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-3">S'enregistrer</button>
</form>

                        
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
