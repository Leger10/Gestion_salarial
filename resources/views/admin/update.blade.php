@extends('layouts.template')

@section('content')
<h3 class="text-center">Modifier les Informations de l'Administrateur</h3>

<form action="{{ route('admin.update', $admin->id) }}" method="POST">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <label for="nom">Nom:</label>
    <input type="text" name="name" value="{{ old('nom', $admin->name) }}" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>

    <label for="departement_id">Département:</label>
    <select name="departement_id" required>
        @foreach ($departements as $departement)
            <option value="{{ $departement->id }}" {{ $departement->id == $admin->departement_id ? 'selected' : '' }}>
                {{ $departement->nom }}
            </option>
        @endforeach
    </select>

    <button type="submit">Mettre à jour</button>
</form>

@endsection
