<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de Paiement | Gestion Salariale</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;500;600&display=swap');
        
        body { 
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #ffffff;
            font-family: 'Playfair Display', serif;
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .amount-card {
            background: linear-gradient(45deg, #00b09b, #96c93d);
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .amount-card:before {
            content: "";
            position: absolute;
            top: -50px;
            right: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .amount {
            font-size: 36px;
            font-weight: 600;
            letter-spacing: 1px;
            margin: 15px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .footer {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
            font-size: 12px;
        }
        
        .signature {
            font-family: 'Playfair Display', serif;
            color: #3498db;
            font-size: 20px;
            margin-top: 25px;
        }
        
        .social-links a {
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gestion Salariale</h1>
            <p style="color: rgba(255,255,255,0.8); margin: 10px 0 0; font-size: 16px;">Excellence en gestion des ressources humaines</p>
        </div>
        
        <div class="content">
            <h2 style="color: #2e77c1; margin: 0 0 25px;">Bonjour {{ $employer->nom }},</h2>
            
            <p style="color: #666; line-height: 1.6; font-size: 16px;">
                Nous avons le plaisir de vous confirmer le versement réussi de votre rémunération pour 
                <strong style="color: #2c3e50;">{{ $month }} {{ $year }}</strong>.
            </p>
            
            <div class="amount-card">
                <div style="opacity: 0.9; font-size: 14px;">Montant net crédité</div>
                <div class="amount">{{ number_format($salaire_net, 0, ',', ' ') }} XOF</div>
                <div style="opacity: 0.9; font-size: 14px;">
                    Référence : <strong>{{ $payment->reference }}</strong>
                </div>
            </div>
            
            <div class="details">
                <p style="margin: 0; color: #d61313; font-size: 14px;">
                    📅 Date de traitement : {{ $payment->done_time->format('d/m/Y à H:i') }}<br>
                    ✅ Statut : Paiement réussi
                </p>
            </div>
            
            <p style="color: #666; line-height: 1.6; font-size: 16px;">
                Merci pour votre engagement et votre contribution précieuse à notre succès commun. 
                Votre dévouement fait toute la différence.
            </p>
            
            <p class="signature">Cordialement,<br>L'Équipe RH</p>
        </div>
        
        <div class="footer">
            <div class="social-links">
            <a href="#" style="color: #95a5a6;">🌍 Notre site</a>
            <br>
            <a href="#" style="color: #95a5a6;">📱 Support</a>
            <br>
            <a href="#" style="color: #95a5a6;">📧 Contact</a>
            </div>
            <p style="margin: 15px 0 0; color: #080e0e; font-size: 11px;">
            Cet email est généré automatiquement - Merci de ne pas y répondre
            </p>
        </div>
        </div>
    </div>
</body>
</html>