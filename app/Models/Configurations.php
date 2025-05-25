<?php

namespace App\Models;
use App\Models\configuration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configurations extends Model
{
    use HasFactory;
    
    protected $fillable = ['type', 'value', 'logo']; // Ajoutez 'logo' ici pour que ce champ soit mass-assignable
}

