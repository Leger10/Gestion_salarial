<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            font-size: 12px;
            /* Réduit la taille pour tenir sur une page */
            line-height: 1.5;
            color: #333;
            position: relative;
            /* Pour positionner le texte "PAYER" */
        }

        /* Forcer le contenu à tenir sur une seule page */
        @page {
            size: A4;
            /* Taille A4 pour impression */
            margin: 10mm 15mm;
            /* Réduit les marges de la page */
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 120px;
        }

        .company-info {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
            color: #555;
        }

        .company-info h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-info img {
            width: 80px;
            margin-top: 5px;
        }

        /* Title Section */
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            /* Couleur verte */
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Section Title */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #444;
            margin-top: 20px;
            text-align: left;
        }

        /* Table Styles */
        .table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            /* Espacement réduit */
            text-align: left;
            font-size: 12px;
        }

        .table th {
            background-color: #f1f1f1;
            color: #555;
        }

        .table td {
            background-color: #fafafa;
        }

        .table tr:nth-child(even) td {
            background-color: #f9f9f9;
            /* Alternance des couleurs */
        }

        /* Footer Section */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            position: relative;
        }

        .footer img {
            width: 70px;
            margin-top: 10px;
        }

        .pay-status {
            font-weight: bold;
            font-size: 16px;
            color: green;
            margin-top: 10px;
        }

        /* Signature en bas à droite */
        .signature {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 120px;
            height: auto;
        }

        /* Texte PAYER en grand, transparent, incliné */
        .pay-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            /* Rotation pour incliner de gauche vers droite */
            font-size: 150px;
            font-weight: bold;
            color: rgba(0, 128, 0, 0.1);
            /* Vert transparent */
            text-align: center;
            pointer-events: none;
            /* Assurez-vous que ce texte ne gêne pas les autres éléments */
        }

        /* Ajustement pour les petits écrans */
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .logo {
                width: 100px;
            }

            .title {
                font-size: 18px;
            }

            .table th,
            .table td {
                font-size: 11px;
                padding: 6px;
            }

            .pay-status {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="company-info">
            <!-- Affichage du nom de l'entreprise -->
            <h3><strong>Entreprise :</strong> {{ $appName->value ?? 'Non défini' }}</h3>

            <!-- Insertion du logo -->

        </div>

    </div>

    <!-- Bulletin Title -->
    <div class="title">Bulletin de salaire</div>

    <!-- Informations du salarié -->
    <div class="section-title">Informations du salarié</div>
    <p><strong>Nom :</strong> {{ $employer->nom }} {{ $employer->prenom }}</p>
    <p><strong>Email :</strong> {{ $employer->email }}</p>
    <p><strong>Téléphone :</strong> {{ $employer->phone }}</p>
    <p><strong>Adresse :</strong> {{ $employer->adresse ?? 'OUAGADOUGOU' }}</p>

    <!-- Détails du salaire -->
    <div class="section-title">Détails du salaire</div>
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

    <p><strong>Date de paiement :</strong> {{ $formattedPaymentDate }}</p>
    <p>Merci pour votre confiance !</p>

    <!-- Footer Section -->
    <div class="footer">
        <!-- Signature -->
        @if(file_exists(public_path('storage/app/public/assets/images/paye-logo.jpg')))
        <img src="{{ asset('storage/app/public/assets/images/paye-logo.jpg') }}" alt="Signature" class="signature">
        @else
        <p>Signature</p>
        @endif

        <!-- Cachet -->
        @if(file_exists(public_path('assets/images/stamp.png')))
        <img src="{{ asset('assets/images/OIP.jpeg') }}" alt="Cachet" class="stamp">
        @else

        @endif
    </div>

    <!-- Texte "PAYER" en filigrane -->
    <div class="pay-watermark">PAYER</div>
</body>

</html>