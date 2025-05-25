<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained()->onDelete('cascade'); // Clé étrangère vers Employer
            $table->date('date'); // Date de l'heure supplémentaire
            $table->decimal('heures', 8, 2); // Heures supplémentaires
            $table->boolean('is_grayed_out')->default(false); // Statut grisé (si l'absence est annulée ou en attente)
            $table->text('note')->nullable(); // Justification pour le grisé (facultatif)
            $table->decimal('original_heures', 8, 2)->nullable(); // Heures d'origine avant d'être grisées (si nécessaire)
            $table->timestamps(); // timestamps de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overtimes');
    }
}
