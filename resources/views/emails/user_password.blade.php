<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Identifiants de connexion</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header img {
            max-width: 150px;
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 15px;
        }

        .credentials {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }

        .credentials strong {
            color: #2c3e50;
            display: inline-block;
            width: 100px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
        }

        .warning {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <!-- Remplacez par votre logo si vous en avez un -->
            <h1>Bienvenue sur notre plateforme</h1>
        </div>
        <p>Bonjour <strong>{{ $nom }} {{ $prenom }}</strong>,</p>
        <p>Votre compte a été créé avec succès. Voici vos identifiants :</p>
        <div class="credentials">
            <p><strong>Email :</strong> {{ $email }}</p>
            <p><strong>Mot de passe :</strong> {{ $password }}</p>
        </div>
        <p class="warning">Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe dès votre
            première connexion.</p>
        <p>Pour accéder à votre compte, cliquez sur le bouton ci-dessous :</p>
        <a href="{{ $url }}" class="button">Accéder à mon compte</a>
        <div class="footer">
            <p>Cordialement,<br>L'équipe <strong>{{ config('app.name') }}</strong></p>
            <p>Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet email.</p>
        </div>
    </div>
</body>

</html>