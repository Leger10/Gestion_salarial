<?php

// app/Models/Departement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];
    public function employers()
    {
        return $this->hasMany(Employer::class); // Assurez-vous que le modèle Employer existe
    }
}


