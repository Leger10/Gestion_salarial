@extends('layouts.template')

@section('content')
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Validation du Compte Administrateur</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-4">
                <h3 class="section-title" style="color: green">Validation du Code</h3>
                <div class="section-intro">Veuillez entrer le code reçu par email pour activer votre compte administrateur</div>
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

                        <form action={{ route('Validate-account', ['email' => $email]) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="code">Code de validation</label>
                                <input type="text" name="code" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Valider le code</button>
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Retour</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
