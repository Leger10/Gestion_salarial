<?php


namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartementsExport implements FromCollection, WithHeadings
{
    protected $departements;

    public function __construct(Collection $departements)
    {
        $this->departements = $departements;
    }

    public function collection()
    {
        return $this->departements;
    }

    public function headings(): array
    {
        return ['ID', 'Nom'];
    }
}
