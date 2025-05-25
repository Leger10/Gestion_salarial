<?php

namespace App\Http\Controllers;

use App\Models\SalaryExport;
use Illuminate\Http\Request;

class SalaryExportController extends Controller
{
    public function index()
    {
        $salaryExports = SalaryExport::all();
        return view('salary_exports.index', compact('salaryExports'));
    }

    public function create()
    {
        return view('salary_exports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'salary_amount' => 'required|numeric',
            'export_date' => 'required|date',
        ]);

        SalaryExport::create($request->all());

        return redirect()->route('salary_exports.index')
            ->with('success', 'Export de salaire créé avec succès.');
    }
}
