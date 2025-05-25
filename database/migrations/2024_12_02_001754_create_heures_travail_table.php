<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('heures_travail', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employer_id')->constrained(); // Clé étrangère vers la table des employeurs
        $table->decimal('heures_travail', 8, 2); // Exemple de colonne pour stocker les heures de travail
        $table->date('date'); // Colonne pour stocker la date
        $table->timestamps(); // Colonnes created_at et updated_at
    });
}

public function down()
{
    Schema::dropIfExists('heures_travail');
}
    };