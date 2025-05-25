<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryExport extends Model
{
    use HasFactory;

    protected $fillable = ['employers_name', 'salary_amount', 'export_date'];
}
