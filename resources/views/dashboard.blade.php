
@extends('layouts.template')
@section('content')
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
    <style>
/* Animation de cercle tournant */
.loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
}

/* Animation de rotation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Style de la carte de notification */
.app-card-notification {
    background: linear-gradient(to top, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.app-card-notification b {
    color: red;
    font-size: 16px;
    font-weight: bold;
}

.app-card-notification i {
    font-size: 20px;
    margin-left: 10px;
    color: green;
}
</style>
<div class="progress-bar">
    <div class="progress"></div>
</div>
<p>Mon rôle est : {{ Auth::user()->role->name }}</p>

<!-- Loader animé -->
<div class="col-auto loader">
    <b style="color: red; font-size: 16px; font-weight: bold;"> 
        <i class="fa-solid fa-hand-point-right"></i></b> </div>
<h1 class="app-page-title">Dashboard</h1>
<div class="row mt-2 mb-2 p-2">
    @if($payementNotification ?? false)
    <div class="app-card app-card-stat shadow-sm h-100 " style="background: linear-gradient(to top, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7)); padding: 15px; border-radius: 8px;">
        <b style="color: red; font-size: 16px; font-weight: bold;"> 
            <i class="fa-solid fa-hand-point-right"></i> Rappel :</b> 
        <span style="font-size: 14px; color: #333;">{{ $payementNotification }}</span>
        <i class="fa-solid fa-hand-holding-dollar" style="font-size: 20px; margin-left: 10px; color: green;"></i>
    </div>
    @endif
</div>

<div class="row g-4 mb-4">
    <!-- Total des départements -->
    <div class="col-12 col-md-4">
        <div class="app-card-body p-40 p-lg-40" style="height: 15%;">
            <div class="app-card app-card-stat shadow-sm h-100" style="background: linear-gradient(to top, rgba(0, 100, 0, 0.61), rgba(0, 128, 0, 0.8));">
                <div class="app-card-body p-40 p-lg-40">
                    <h1><b class="stats-type mb-1" style="color:#000">Total Départements</b></h1>
                    <div class="stats-figure" style="color:#0D1F7F">{{ $totalDepartements ?? 0 }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('departements.index') }}" style="color: #4dba0d"></a>
            </div>
        </div>
    </div>

    <!-- Total des Employeurs -->
    <div class="col-12 col-md-4">
        <div class="app-card-body p-40 p-lg-40" style="height: 15%;">
            <div class="app-card app-card-stat shadow-sm h-100" style="background: linear-gradient(to top, rgba(64, 224, 208, 0.61), rgba(72, 209, 204, 0.8));">
                <div class="app-card-body p-40 p-lg-40">
                    <h1><b class="stats-type mb-1" style="color:#000;">Total Employers</b></h1>
                    <div class="stats-figure" style="color: #0D1F7F">{{ $totalEmployers ?? 0 }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('employers.index') }}"></a>
            </div>
        </div>
    </div>

    <!-- Total des Administrateurs -->
    <div class="col-12 col-md-4">
        <div class="app-card-body p-40 p-lg-40" style="height: 15%;">
            <div class="app-card app-card-stat shadow-sm h-100" style="background: linear-gradient(to top, rgba(0, 100, 0, 0.61), rgba(0, 128, 0, 0.8));">
                <div class="app-card-body p-40 p-lg-40">
                    <h1><b class="stats-type mb-1" style="color:#000">Total Administrateurs</b></h1>
                    <div class="stats-figure" style="color:#0D1F7F">{{ $totalAdministrateurs ?? 0 }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.index') }}" style="color: #4dba0d"></a>
            </div>
        </div>
    </div>

    <!-- Total des heures de Travail -->
    <div class="col-12 col-md-4">
        <div class="app-card-body p-40 p-lg-40" style="height: 15%;">
            <div class="app-card app-card-stat shadow-sm h-100" style="background-color: #0D1F7F;">
                <div class="app-card-body p-40 p-lg-40">
                    <h1><b class="stats-type mb-1" style="color:#000">Total des heures de Travail</b></h1>
                    <div class="stats-figure" style="color: #00BCD4;">
                        {{ $totalHeuresTravailAll }} h
                    </div>
                </div>
                <a class="app-card-link-mask" href="{{ route('employers.index') }}" style="color: #4dba0d"></a>
            </div>
        </div>
    </div>

    <!-- Total des heures d'Absence -->
    <div class="col-12 col-md-4">
        <div class="app-card-body p-40 p-lg-40" style="height: 15%;">
            <div class="app-card app-card-stat shadow-sm h-100" style="background: linear-gradient(to top, rgba(0, 100, 0, 0.61), rgba(0, 128, 0, 0.8));">
                <div class="app-card-body p-40 p-lg-40">
                    <h1><b class="stats-type mb-1" style="color:#000">Total des heures Absences</b></h1>
                    <div class="stats-figure" style="color:#0D1F7F">{{ $totalAbsenceHeuresAll }} h</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('employers.index') }}" style="color: #4dba0d"></a>
            </div>
        </div>
    </div>
<!-- Total des Salaires Globaux -->
<div class="card">
    <div class="app-card-body p-40 p-lg-40" style="height: 15%;">
        <div class="app-card app-card-stat shadow-sm h-100" style="background: linear-gradient(to top, rgba(11, 173, 24, 0.61), rgba(0, 128, 0, 0.8));">
            <div class="app-card-body p-40 p-lg-40">
                <h1><b class="stats-type mb-1" style="color:#0D1F7F">Total des Salaires Globaux</b></h1>
                <div class="stats-figure" ><h4 style="color: #FF0000">{{ number_format($totalSalairesGlobal, 2, ',', ' ') }} FCFA</h4>
                </div>
            </div>
            <a class="app-card-link-mask" href="{{ route('paiements.index') }}" style="color: #4dba0d"></a>
        </div>
    </div>
</div>



<style>
.app-card-body {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.app-card-body:hover {
    transform: scale(1.05);  /* Agrandir légèrement la carte */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* Ajoute de l'ombre pour un effet de profondeur */
}
</style>

<div class="row g-4 mb-4">
    <!-- Premier graphique : Secteurs - Heures de travail et Salaires -->
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title" style="color: green">Graphique Secteurs - Heures de travail et Salaires</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <a href="charts.html">Plus de graphiques</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3 p-lg-4">
                <div class="chart-container">
                    <canvas id="canvas-pie-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Deuxième graphique : Secteurs - Salaire Par Mois -->
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title" style="color: green">Graphique Secteurs - Salaire Par Mois</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <a href="charts.html">Plus de graphiques</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3 p-lg-4">
                <div class="chart-container">
                    <canvas id="canvas-bar-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.progress-bar {
    width: 100%;
    background-color: #f3f3f3;
    border-radius: 10px;
    height: 20px;
    overflow: hidden;
}

.progress {
    background-color: #4caf50;
    height: 100%;
    width: 0;
    border-radius: 10px;
    transition: width 1s ease-in-out;
}
</style>

    
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-4">
            <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                <div class="app-card-header p-3 border-bottom-0">
                    <div class="row align-items-center gx-3">
                        <div class="col-auto">
                            <div class="app-icon-holder">
                                <!-- SVG icon -->
                            </div><!--//icon-holder-->
                        </div><!--//col-->
                        <div class="col-auto">
                            <h4 class="app-card-title" style="color: green">Bulles de neige</h4>
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-footer p-4 mt-auto text-center"> <!-- Ajout de text-center -->
                   <a class="class="btn app-btn-secondary mb-3 w-100" href="#"> <i class="fa-solid fa-eye"></i> Voir</a> <!-- w-100 pour largeur pleine -->
                </div><!--//app-card-footer-->
            </div><!--//app-card-->
        </div><!--//col-->
    
    <div class="col-12 col-lg-4">
        <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder">
                            <!-- SVG icon -->
                        </div><!--//icon-holder-->
                    </div><!--//col-->
                    <div class="col-auto">
                        <h4 class="app-card-title" style="color: green">Applications</h4>
                    </div><!--//col-->
                </div><!--//row-->
            </div><!--//app-card-header-->
            <div class="app-card-footer p-4 mt-auto text-center"> <!-- Ajout de text-center -->
               <a class="class="btn app-btn-secondary mb-3 w-100" href="#"> <i class="fa-solid fa-eye"></i> Voir</a> <!-- w-100 pour largeur pleine -->
            </div><!--//app-card-footer-->
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-12 col-lg-4">
        <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder">
                            <!-- SVG icon -->
                        </div><!--//icon-holder-->
                    </div><!--//col-->
                    <div class="col-auto">
                        <h4 class="app-card-title" style="color: green">Outils</h4>
                    </div><!--//col-->
                </div><!--//row-->
            </div><!--//app-card-header-->
            <div class="app-card-footer p-4 mt-auto text-center"> <!-- Ajout de text-center -->
               <a class="class="btn app-btn-secondary mb-3 w-100" href="#"> <i class="fa-solid fa-eye"></i> Voir</a> <!-- w-100 pour largeur pleine -->
            </div><!--//app-card-footer-->
        </div><!--//app-card-->
    </div><!--//col-->
</div><!--//row-->

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifier si la variable 'salaire_net_par_mois_annee' est bien définie dans la vue
        const salaryData = @json($totalSalairesGlobal); // Données des salaires nets par mois et année
        
        // Préparer les labels et les données
        const labels = [];
        const salaries = [];
        
        // Parcours de toutes les clés (mois-année)
        for (const key in salaryData) {
            if (salaryData.hasOwnProperty(key)) {
                const [annee, mois] = key.split('-');
                labels.push(`${mois}/${annee}`); // Format du label : Mois/Année
                salaries.push(salaryData[key]); // Total des salaires pour ce mois/année
            }
        }

        // Initialisation du graphique
        const ctx = document.getElementById('salaryChart').getContext('2d');
        const salaryChart = new Chart(ctx, {
            type: 'line', // Type de graphique : 'line', 'bar', etc.
            data: {
                labels: labels,
                datasets: [{
                    label: 'Salaires Nets Mensuels',
                    data: salaries,
                    borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la ligne
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de fond de la ligne
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    let progress = document.querySelector('.progress');
let width = 0;

function updateProgressBar() {
    if (width >= 100) {
        width = 0;  // Réinitialiser la largeur pour repartir à 0
    }
    width += 5;  // Augmenter la largeur de 5%
    progress.style.width = width + '%';
}

// Animer la barre toutes les 1 seconde
setInterval(updateProgressBar, 1000);

    // Récupérer les données envoyées depuis le contrôleur (passées en variables PHP)
    var totalHeuresTravail = @json($totalHeuresTravailAll);
    var totalSalaires = @json($totalSalairesGlobal);
    var totalAbsences = @json($totalAbsenceHeuresAll);

    console.log('Total Heures de travail: ' + totalHeuresTravail);
    console.log('Total Salaires: ' + totalSalaires);
    console.log('Total Absences: ' + totalAbsences);

    // Créer un graphique circulaire (pie chart)
    var ctx = document.getElementById('canvas-pie-chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',  // Type de graphique circulaire
        data: {
            labels: ['Heures de travail', 'Salaires', 'Absences'],  // Étiquettes
            datasets: [{
                data: [totalHeuresTravail, totalSalaires, totalAbsences],  // Données des trois catégories
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)', // Couleur pour les heures de travail
                    'rgba(255, 99, 132, 0.6)', // Couleur pour les salaires
                    'rgba(255, 159, 64, 0.6)'  // Couleur pour les absences
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',   // Bordure pour les heures de travail
                    'rgba(255, 99, 132, 1)',   // Bordure pour les salaires
                    'rgba(255, 159, 64, 1)'    // Bordure pour les absences
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',  // Position de la légende
                },
                tooltip: {
                    enabled: true,  // Afficher les tooltips
                    callbacks: {
                        // Formatage du tooltip pour ajouter "FCFA" et "h"
                        label: function(tooltipItem) {
                            var label = tooltipItem.label;
                            var value = tooltipItem.raw;

                            if (label === 'Heures de travail' || label === 'Absences') {
                                // Pour les heures, ajouter "h"
                                return label + ': ' + value + ' h';
                            } else if (label === 'Salaires') {
                                // Pour les salaires, ajouter "FCFA"
                                return label + ': ' + value + ' FCFA';
                            }
                            return label + ': ' + value;
                        }
                    }
                }
            }
        }
    });
</script>

@endsection