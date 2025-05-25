@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un Export de Salaire</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('salary_exports.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="employee_name">Nom de l'employé</label>
            <input type="text" name="employee_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="salary_amount">Montant du salaire</label>
            <input type="text" name="salary_amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="export_date">Date d'export</label>
            <input type="date" name="export_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection
