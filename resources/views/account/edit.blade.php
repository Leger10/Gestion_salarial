<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Modifier mon compte</title>
    <!-- Inclure Font Awesome pour l'icône de l'œil -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px; /* Ajoute de l'espace pour l'icône */
        }

        .password-container i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container my-5" style="max-width: 600px; margin: auto;">
        <h1 class="text-center">Modifier mon Compte</h1>

        <!-- Formulaire de modification des informations personnelles -->
        <form action="{{ route('account.update') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <!-- Champ pour le mot de passe actuel avec icône à l'intérieur -->
            <div class="mb-3 password-container">
                <label for="current_password" class="form-label">Mot de passe actuel</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>

            <!-- Bouton pour soumettre les changements -->
            <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
        </form>

        <!-- Formulaire pour supprimer le compte -->
        <form action="{{ route('account.delete') }}" method="POST" class="mt-5" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
            @csrf
            @method('DELETE')

            <!-- Bouton pour supprimer le compte -->
            <button type="submit" class="btn btn-danger w-100" style="background-color: red;">Supprimer mon compte</button>
        </form>
    </div>

    <!-- Script pour basculer entre mot de passe visible/invisible -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#current_password');

        togglePassword.addEventListener('click', function () {
            // Bascule entre le type texte et mot de passe
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Bascule l'icône
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
