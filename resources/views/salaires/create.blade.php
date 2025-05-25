@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Salaire</h1>
    <form action="{{ route('salaires.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="employer_id" class="form-label">Employeur</label>
            <select name="employer_id" id="employer_id" class="form-control">
                @foreach($employers as $employer)
                    <option value="{{ $employer->id }}">{{ $employer->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="text" name="montant" id="montant" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection


