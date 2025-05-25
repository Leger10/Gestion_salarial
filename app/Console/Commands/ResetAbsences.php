<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Absence;

class ResetAbsences extends Command
{
    protected $signature = 'absences:reset';
    protected $description = 'Réinitialiser les heures d\'absence pour chaque employé à la fin du mois';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Vérifier que nous sommes à la fin du mois
        if (Carbon::now()->isLastOfMonth()) {
            Absence::query()->update(['heures_absence' => 0]); // Réinitialiser toutes les absences à 0
            $this->info('Les heures d\'absence ont été réinitialisées avec succès!');
        } else {
            $this->info('Ce n\'est pas la fin du mois.');
        }
    }
}
