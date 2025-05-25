<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Attributs autorisés à être remplis en masse
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role_id',
         'verification_code',
    'verification_code_expires_at'
    ];

    /**
     * Attributs masqués lors de la sérialisation
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de colonnes vers types spécifiques
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relations
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Vérification de rôles
     */
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isUser()
    {
        return $this->role_id === 2;
    }

    public function isSuperAdmin()
    {
        return $this->role_id === 3;
    }

    public function isSuperAdminOrAdmin()
    {
        return in_array($this->role_id, [1, 3]);
    }

    public function isSuperAdminOrUser()
    {
        return in_array($this->role_id, [2, 3]);
    }

    public function isSuperAdminOrAdminOrUser()
    {
        return in_array($this->role_id, [1, 2, 3]);
    }

    public function isAdminOrUser()
    {
        return in_array($this->role_id, [1, 2]);
    }

    public function isAdminOrSuperAdmin()
    {
        return in_array($this->role_id, [1, 3]);
    }

    public function isUserOrSuperAdmin()
    {
        return in_array($this->role_id, [2, 3]);
    }

    public function isUserOrAdmin()
    {
        return in_array($this->role_id, [1, 2]);
    }

    /**
     * Retourne le nom du rôle lisible
     */
    public function getRoleName()
    {
        return match ($this->role_id) {
            1 => 'Administrateur',
            2 => 'Utilisateur',
            3 => 'Super Administrateur',
            default => 'Inconnu',
        };
    }

    /**
     * Récupère tous les super administrateurs (utile dans les contrôleurs)
     */
    public static function superAdmins()
    {
        return self::where('role_id', 3)->get();
    }
}
