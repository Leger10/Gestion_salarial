<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absence_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('absence_id');  // Référence à l'absence
            $table->unsignedBigInteger('employer_id'); // Référence à l'employé
            $table->decimal('heures', 8, 2);  // Heures originales ou modifiées
            $table->boolean('is_grayed_out'); // Indique si l'absence a été grisée ou non
            $table->timestamp('changed_at');  // Date et heure de la modification
            $table->timestamps();
            
            // Ajout des clés étrangères
            $table->foreign('absence_id')->references('id')->on('absences')->onDelete('cascade');
            $table->foreign('employer_id')->references('id')->on('employers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absence_histories');
    }
};
