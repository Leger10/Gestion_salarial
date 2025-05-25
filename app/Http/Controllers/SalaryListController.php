<?php

namespace App\Http\Controllers;

use App\Models\Salary;

class SalaryListController extends Controller
{
    public function index()
    {
        // Calculez le total des heures de travail
        $totalHeuresTravail = SalaireEmployer::sum('heures_travail');

        // Récupérez tous les salaires si nécessaire
        $salaries = SalaireEmployer::all();
        
        return view('salaries.index', compact('salaries', 'totalHeuresTravail'));
    }
}
