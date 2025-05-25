<form method="POST" action="{{ route('profile.password') }}">
    @csrf

    <div>
        <label for="current_password">Mot de passe actuel</label>
        <input type="password" name="current_password" required>
    </div>

    <div>
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" name="new_password" required>
    </div>

    <div>
        <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
        <input type="password" name="new_password_confirmation" required>
    </div>

    <button type="submit">Changer le mot de passe</button>
</form>
