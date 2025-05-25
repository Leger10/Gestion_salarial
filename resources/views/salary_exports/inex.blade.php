@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Exports de Salaires</h1>
    <a href="{{ route('salary_exports.create') }}" class="btn btn-primary mb-3">Ajouter un export</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nom de l'employé</th>
                <th>Montant du salaire</th>
                <th>Date d'export</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaryExports as $export)
            <tr>
                <td>{{ $export->employee_name }}</td>
                <td>{{ $export->salary_amount }}</td>
                <td>{{ $export->export_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
