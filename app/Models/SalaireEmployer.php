<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaireEmployer extends Model
{
    use HasFactory;

    const EMPLOYER_ID = 'employer_id';
    const MONTANT = 'montant';

    protected $fillable = [
        self::EMPLOYER_ID,
        self::MONTANT,
    ];

    protected $casts = [
        self::MONTANT => 'float',
    ];

    // Relation avec l'employeur
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    // Scope pour filtrer par employeur
    public function scopeByEmployer($query, $employerId)
    {
        return $query->where('employer_id', $employerId);
    }
}
