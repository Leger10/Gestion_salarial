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
        // Créer la table employers
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email', 255)->unique();
            $table->string('phone');
            $table->unsignedInteger('montant_journalier')->nullable(); // Ajouter le montant journalier
            $table->unsignedInteger('heures_travail')->nullable(); // Ajouter les heures de travail
            $table->foreignId('departement_id')->constrained(); // Assurez-vous que la relation est correcte
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Supprimer uniquement la clé étrangère sans toucher aux colonnes montant_journalier et heures_travail
        Schema::table('employers', function (Blueprint $table) {
            $table->dropForeign(['departement_id']); // Supprimer la clé étrangère
        });

        // Supprimer la table sans toucher aux colonnes
        Schema::dropIfExists('employers');
    }
};
