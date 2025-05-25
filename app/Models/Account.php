<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_type',
        'balance',
    ];

    // Définir la relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
