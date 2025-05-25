<form action="{{ route('employers.update', $employer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="nom">Nom:</label>
    <input type="text" name="nom" value="{{ old('nom', $employer->nom) }}" required>

    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" value="{{ old('prenom', $employer->prenom) }}" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email', $employer->email) }}" required>

    <label for="phone">Téléphone:</label>
    <input type="text" name="phone" value="{{ old('phone', $employer->phone) }}" required>

    <label for="departement_id">Département:</label>
    <select name="departement_id" required>
        @foreach ($departements as $departement)
            <option value="{{ $departement->id }}" {{ $departement->id == $employer->departement_id ? 'selected' : '' }}>
                {{ $departement->nom }}
            </option>
        @endforeach
    </select>

    <label for="salaire">Salaire:</label>
    <input type="number" name="salaire" value="{{ old('salaire', $employer->salaire) }}" >

    <label for="statut_paiement">Statut de Paiement:</label>
    <input type="text" name="statut_paiement" value="{{ old('statut_paiement', $employer->statut_paiement) }}" required>

    <label for="retard_paiement">Retard de Paiement:</label>
    <select name="retard_paiement" required>
        <option value="oui" {{ $employer->retard_paiement == 'oui' ? 'selected' : '' }}>Oui</option>
        <option value="non" {{ $employer->retard_paiement == 'non' ? 'selected' : '' }}>Non</option>
    </select>

    <button type="submit">Mettre à jour</button>
</form>
