@extends('layouts.app')

@section('content')
    <style>
        html, body {
            height: 100%;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .footer-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .footer-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .login-form {
            position: absolute;
            top: 20%;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .login-form h3 {
            font-weight: bold;
            color: #28a745;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-link {
            color: #007bff;
        }

        .btn-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="footer-image">
        <a href="https://fr.freepik.com/vecteurs/baground-design" target="_blank" rel="noopener noreferrer">
            <img src="https://img.freepik.com/vecteurs-libre/cristal-fond-abstrait-colore-geometrique_343694-2894.jpg?semt=ais_hybrid&w=740"
                 alt="Image Web">
        </a>

        <div class="login-form">
            <h3 class="text-center">Espace de connexion</h3>
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="email">{{ __('Adresse E-Mail') }}</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password">{{ __('Mot de passe') }}</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group form-check mb-3">
                    <input class="form-check-input" type="checkbox"
                           name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Se souvenir de moi') }}
                    </label>
                </div>

                <div class="form-group mb-0 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary px-4">
                        {{ __('Connexion') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
