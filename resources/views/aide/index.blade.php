@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Aide</title>
    
</head>
<body>
    <div class="help-section" >
        <h1 style="color: #2a9c44">Section d'Aide</h1>
        <p>Bienvenue dans la section d'aide. Comment pouvons-nous vous aider ?</p>

        <form action="{{ route('aide.index') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="message"> Entrer votre message :</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            
            <button type="submit">Envoyer</button>
        </form>
        
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p>
            Pour plus d'aide, consultez notre <a href="https://www.facebook.com/share/v/uj36F2CYmzKXEFam/">tutoriel ici</a>.
        </p>
    </div>
</body>
</html>
@endsection