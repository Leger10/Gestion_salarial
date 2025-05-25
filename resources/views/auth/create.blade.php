<!DOCTYPE html>
<html>
<head>
    <title>Créer un Utilisateur</title>
</head>
<body>
    <h1>Créer un Utilisateur</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="password_confirmation">Confirmer le mot de passe :</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <br>
        <button type="submit">Créer</button>
    </form>
</body>
</html>
