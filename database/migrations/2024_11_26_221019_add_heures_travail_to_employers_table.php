<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employers', function (Blueprint $table) {
            // Vérifie si la colonne 'heures_travail' n'existe pas avant de l'ajouter
            if (!Schema::hasColumn('employers', 'heures_travail')) {
                $table->integer('heures_travail')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('employers', function (Blueprint $table) {
        // Supprimer la colonne 'heures_travail' si elle existe
        if (Schema::hasColumn('employers', 'heures_travail')) {
            $table->dropColumn('heures_travail');
        }
    });
}

};
