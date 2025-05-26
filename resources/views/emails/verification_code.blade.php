<!DOCTYPE html>
<html>
<head>
    <title>Vérification de compte</title>
</head>
<body>
    <h1>Bonjour {{ $user->name }},</h1>
    
    <p>Votre compte a été créé avec succès sur {{ config('app.name') }}.</p>
    
    <p><strong>Code de vérification :</strong> {{ $verificationCode }}</p>
    
    <p>Ce code expirera dans 15 minutes.</p>
    
    <a href="{{ route('auth.defineAccess', ['email' => $user->email]) }}" style="background: #4F46E5; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
        Valider mon compte
    </a>
    <div class="footer">
            <p>Cordialement,<br>L'équipe <strong>{{ config('app.name') }}</strong></p>
            <p>Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet email.</p>
        </div>
    <p>Merci,<br>{{ config('app.name') }}</p>
</body>
</html>













{{--  @component('mail::message')
# Bonjour {{ $user->name }},

Votre compte a été créé avec succès sur la plateforme {{ config('app.name') }}.

**Voici votre code de vérification :**  
<span style="font-size: 24px; font-weight: bold; color: #2d3748;">{{ $verificationCode }}</span>

Ce code expirera dans 15 minutes.

@component('mail::button', ['url' => route('verification.show', ['email' => $user->email])])
Valider mon compte
@endcomponent

Si vous n'avez pas créé de compte, veuillez ignorer cet email.

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent










{{--  <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de votre compte </title>
</head>
<body>
    <b><p>Bonjour {{ $user->name }},</p></b>
    <p>Votre compte a été créé avec succès sur la plateforme de gestion des salaires et des employés.</p>
    <p>Voici votre code de vérification <span style="color: green;">{{ $verificationCode }}</span></p>
    
    <p>Cliquez sur le lien pour renseigner ce code et définir votre propre mot de passe :</p>
    <p><a href="{{ route('auth.defineAccess', ['email' => $user->email]) }}"><span style="color: green;">Cliquer ici</span></a></p>
    
    <p>Merci de votre inscription !</p>
    </body>
    </html>
      --}}  
