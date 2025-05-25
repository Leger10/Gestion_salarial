@extends('layouts.template')

@section('content')
    <h1>Heures de travail pour {{ $employer->nom }} {{ $employer->prenom }} - Mois {{ $mois }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table app-table-hover mb-0 text-left table-striped table-bordered">
        <thead>
            <tr>
                <th class="cell">Date</th>
                <th class="cell">Heures de travail</th>
                <th class="cell">Présent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($heures as $heure)
                <tr>
                    <td>{{ $heure->date->format('d-m-Y') }}</td>
                    <td>{{ $heure->heures_travail }}</td>
                    <td>{{ $heure->est_present ? 'Oui' : 'Non' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <h4>Total des heures de travail ce mois-ci : {{ $totalHeures }} heures</h4>
        <a href="{{ route('employers.ajouterHeures', $employer->id) }}" class="btn btn-success">Ajouter des heures</a>
    </div>
@endsection
