@extends('layouts.template')

@section('content')
@if($admin)
    <b style="color: green">Détails de l'administrateur</b>
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h3>{{ $admin->nom_complet }}</h3>
            <p><strong>ID :</strong> {{ $admin->id }}</p>
            <p><strong>Email :</strong> {{ $admin->email }}</p>
            <div class="mt-4">
                <form action="{{ route('admin.delete', $admin->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');">Supprimer</button>
                      <a href="{{ route('admin.index') }}" class="btn btn-secondary">Retour à la liste des administrateurs</a>
                </form>
            </div>
        </div>
    </div>
@else
    <p>Admin not found.</p>
@endif
@endsection
