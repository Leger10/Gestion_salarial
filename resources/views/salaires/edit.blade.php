@extends('layouts.app')

@section('content')
<h1>Modifier le Salaire</h1>
<form action="{{ route('salaries.update', $salary->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="employee_name">Nom de l'employé</label>
    <input type="text" name="employee_name" value="{{ $salary->employee_name }}" required>

    <label for="position">Poste</label>
    <input type="text" name="position" value="{{ $salary->position }}" required>

    <label for="amount">Montant</label>
    <input type="number" name="amount" value="{{ $salary->amount }}" required>

    <label for="payment_date">Date de paiement</label>
    <input type="date" name="payment_date" value="{{ $salary->payment_date }}" required>

    <button type="submit">Modifier</button>
</form>
@endsection