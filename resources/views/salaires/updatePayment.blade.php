@extends('layouts.app')

@section('content')
<form action="{{ route('employers.updatePayment', $employer->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div>
        <label for="salaire">Salaire</label>
        <input type="number" id="salaire" name="salaire" required>
    </div>

    <div>
        <label for="statut_paiement">Statut de Paiement</label>
        <select id="statut_paiement" name="statut_paiement">
            <option value="payé">Payé</option>
            <option value="non payé">Non payé</option>
        </select>
    </div>

    <div>
        <label for="retard_paiement">Retard de Paiement</label>
        <input type="checkbox" id="retard_paiement" name="retard_paiement">
    </div>

    <button type="submit">Mettre à jour les détails de paiement</button>
</form>
@endsection