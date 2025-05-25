<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerificationCodeToUsersTable extends Migration
{
    public function up()
    {
        // Vérifie si la colonne 'verification_code' n'existe pas avant de l'ajouter
        if (!Schema::hasColumn('users', 'verification_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('verification_code')->nullable();
            });
        }
    }

    public function down()
    {
        // Supprimer la colonne 'verification_code' si elle existe
        if (Schema::hasColumn('users', 'verification_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('verification_code');
            });
        }
    }
}
