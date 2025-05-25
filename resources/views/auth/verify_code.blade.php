@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Vérification de l\'email') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('validate.code') }}">
                        @csrf

                        <div class="form-group">
                            <label for="code">{{ __('Code de vérification') }}</label>
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autofocus>
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="password">{{ __('Mot de passe') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="password-confirm">{{ __('Confirmer le mot de passe') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="form-group mt-3 mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Valider') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
