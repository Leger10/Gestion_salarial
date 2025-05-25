
@extends('layouts.app') 
  
@section('content') 
<style>
    .profile-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-container h1 {
        font-size: 28px;
        color: #343a40;
        margin-bottom: 20px;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
    }

    .profile-container p {
        font-size: 16px;
        color: #495057;
        margin-bottom: 15px;
    }

    .profile-container img {
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .btn-outline-primary {
        text-decoration: none;
        font-size: 16px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: rgb(54, 51, 51) !important;
        border-color: #0d6efd;
    }
</style>

<div class="profile-container">
    <h1>Profil de {{ $user->nom }} {{ $user->prenom }}</h1>

    <p><strong>Adresse :</strong> {{ $user->profile->adresse }}</p>
    <p><strong>Téléphone :</strong> {{ $user->profile->phone }}</p>

    <p><strong>Photo :</strong></p>
    <img src="{{ asset('avatars/default.png') }}" alt="Photo de profil" width="150">

    <br>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">← Retour au dashboard</a>
</div>

@endsection 