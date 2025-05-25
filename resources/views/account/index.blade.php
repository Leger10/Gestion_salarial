
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<div class="container my-5"> <!-- Ajout de marges pour un meilleur espacement -->
    <h1 class="text-center">Mon Compte</h1> <!-- Centre le titre -->

    @if (session('success'))
        <div class="alert alert-success">
            {!! htmlspecialchars_decode(session('success')) !!} <!-- Affiche le message souligné -->
        </div>
    @endif

    <div class="container mt-5"> <!-- Ajout d'une conteneur pour l'espacement et le centrage -->
        <div class="card shadow-sm" style="max-width: 500px; margin: auto;"> <!-- Ajout d'une carte avec ombre et centrage -->
            <div class="card-header bg-primary text-white text-center"> <!-- Centrage du texte et ajout d'un fond bleu -->
                <h4 class="mb-0">Détails du compte</h4> <!-- Titre centré -->
            </div>
            <div class="card-body text-center"> <!-- Centrage des détails -->
                <p><strong>Nom d'utilisateur :</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                <p><strong>Date de création :</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    
        <div class="mt-4 text-center d-flex flex-column align-items-center"> <!-- Centre les boutons verticalement -->
            <form action="{{ route('account.edit') }}" method="GET" class="mb-2"> <!-- Forme pour modifier le compte -->
                <button type="submit" class="btn btn-primary">Modifier mon compte</button> <!-- Bouton bleu -->
            </form>
            
            <form action="{{ route('account.delete') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');"> <!-- Forme pour supprimer le compte -->
                @csrf
                @method('DELETE')
             <button type="submit" class="btn btn-danger" style="background-color: red;">Supprimer mon compte</button> <!-- Bouton rouge -->

            </form>
        </div>
    </div>
    