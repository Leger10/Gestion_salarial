@extends('layouts.template')

@section('content')

<div class="row g-4 settings-section">
    <div class="col-12 col-md-8 mx-auto">
        <div class="app-card app-card-settings shadow-sm p-4" style="background-color: #f7c6d9; border-radius: 10px;">
            <div class="app-card-body logo_center">
                <img src="{{ asset('assets/images/armoirie.png') }}" alt="Logo armoirie" style="width: 180px;">
            </div>

            <!-- Styles spécifiques pour la mise en page -->
            @section('styles')
                <style>
                    .logo_center {
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-start; /* Aligner l'image en haut */
                        align-items: center; /* Centrer l'image horizontalement */
                        text-align: center; /* Centrer le texte sous l'image */
                    }
                </style>
            @endsection

            <div class="app-card-body">
                <!-- Insertion du logo -->
                <p><h3><strong>Entreprise :</strong> {{ $appName->value ?? 'Non défini' }}</h3></p>

                @if(isset($configuration) && $configuration->logo)
                    <img src="{{ asset('storage/' . $configuration->logo) }}" alt="Logo" style="width: 100px; height: auto;">
                @else
                    <p>Aucune image</p>
                @endif

                <b><h1 class="text-center" style="color: green; font-size: 28px;">Bulletin de salaire</h1></b>

                <h3 class="text-center">Informations du salarié</h3>
                <p><strong>Nom :</strong> {{ $employer->nom }} {{ $employer->prenom }}</p>
                <p><strong>Email :</strong> {{ $employer->email }}</p>
                <p><strong>Téléphone :</strong> {{ $employer->phone }}</p>
                <p><strong>Adresse :</strong> {{ $employer->adresse ?? 'OUAGADOUGOU' }}</p>

                <h3 class="text-center mt-4">Détails du salaire</h3>
                <table class="table table-striped mt-2">
                    <tr>
                        <th>Montant journalier :</th>
                        <td>{{ number_format($employer->montant_journalier, 0, ',', ' ') }} CFA</td>
                    </tr>
                    <tr>
                        <th>Heures de travail par jour :</th>
                        <td>{{ number_format($employer->heures_travail, 0, ',', ' ') }} heure(s)</td>
                    </tr>
                    <tr>
                        <th>Heures totales de travail :</th>
                        <td>{{ number_format($totalHeuresTravail, 0, ',', ' ') }} heure(s)</td>
                    </tr>
                    <tr>
                        <th>Heures d'absence :</th>
                        <td>{{ number_format($absences, 0, ',', ' ') }} heure(s)</td>
                    </tr>
                    <tr>
                        <th>Heures supplémentaires :</th>
                        <td>{{ number_format($heures_supplementaires, 0, ',', ' ') }} heure(s)</td>
                    </tr>
                    <tr>
                        <th>Salaire total avant taxes :</th>
                        <td>{{ number_format($salaire_total_avant_taxes, 0, ',', ' ') }} CFA</td>
                    </tr>
                    <tr>
                        <th>Taxe retenue :</th>
                        <td>{{ number_format($taxe, 0, ',', ' ') }} CFA</td>
                    </tr>
                    <tr>
                        <th>Salaire net à payer :</th>
                        <td>{{ number_format($salaire_net, 0, ',', ' ') }} CFA</td>
                    </tr>
                </table>

                <div class="text-center mt-4">
                    <p><strong>Date de paiement : </strong> {{ $formattedPaymentDate }}</p>
                    <p>Merci pour votre confiance ! Conservez ce reçu comme preuve de votre transaction.</p>
                </div>

            </div> <!-- .app-card-body -->
        </div> <!-- .app-card -->
    </div> <!-- .col-12 col-md-8 -->
</div> <!-- .row -->

<!-- Bouton pour retourner à la liste des employés -->
<div class="text-center mt-3">
    <a href="{{ route('employers.salaire') }}" class="btn btn-secondary">Retour à la liste</a>
</div>

@endsection
