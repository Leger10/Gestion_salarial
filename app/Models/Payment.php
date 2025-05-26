<?php
namespace App\Models;
use App\Models\Configurations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
class Payment extends Model
{
    use HasFactory;

    // Table associée
    protected $table = 'payments';

    // Les attributs qui sont assignables en masse (mass-assignment)
    protected $fillable = [
        'reference',
        'employer_id',
        'montant_journalier',
        'heures_travail',
        'heures_totales',
        'heures_absence',
        'salaire_total_avant_taxes',
        'taxe',
        'salaire_net',
        'launch_date',
        'done_time',
        'status',
        'month',
        'year',

    ];
    protected $casts = [
    'salaire_net' => 'decimal:2',
    'done_time' => 'datetime'
];

    // Les attributs qui doivent être cachés pour les tableaux
    protected $hidden = [
        // Exemple: 'created_at', 'updated_at'
    ];

    // Définir la relation avec le modèle Employer
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    // Définir un accessor pour le champ 'launch_date' pour le formater comme vous le souhaitez
    public function getLaunchDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    // Définir un mutator pour le champ 'done_time' si vous voulez lui appliquer un format spécifique avant la sauvegarde
    public function setDoneTimeAttribute($value)
    {
        $this->attributes['done_time'] = \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    // Accessor pour récupérer le nom de l'application (depuis la config)
    public function getAppName()
    {
        return config('app.name'); // Récupère le nom de l'application défini dans config/app.php
    }

    // Accessor pour récupérer le logo de l'application (depuis la base de données ou un fichier)
    public function getAppLogo()
    {
        // Si le logo est stocké dans la base de données
        $configuration =Configurations::first(); // Exemple, assurez-vous de récupérer correctement la config
        return $configuration ? asset('storage/' . $configuration->logo) : null;
    }
    public function export()
    {
        return Excel::download(new PaymentsExport, 'paiements.xlsx');
    }
    
}
