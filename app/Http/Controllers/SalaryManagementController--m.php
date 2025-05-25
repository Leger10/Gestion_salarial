<?php
namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryManagementController extends Controller
{
    public function create()
    {
        return view('salaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string',
            'position' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        Salary::create($request->all());
        return redirect()->route('salaries.index');
    }

    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        return view('salaries.edit', compact('salary'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_name' => 'required|string',
            'position' => 'required|string',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
        ]);

        $salary = Salary::findOrFail($id);
        $salary->update($request->all());
        return redirect()->route('salaries.index');
    }

    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();
        return redirect()->route('salaries.index');
    }
}
