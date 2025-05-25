@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Vérification de votre code</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('verification.verify') }}">
            @csrf
            <div class="form-group">
                <label for="verification_code">Code de vérification</label>
                <input type="text" name="verification_code" id="verification_code" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Vérifier</button>
        </form>
    </div>
@endsection
