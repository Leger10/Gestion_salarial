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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade'); 
            $table->date('date');
            $table->integer('heures_absence')->default(0)->change(); 
            // Heures d'absence par jour
            $table->timestamps();
        });
   
       
        
        // Ajouter un index unique pour empêcher les doublons (un employé ne peut pas être absent deux fois le même jour)
        Schema::table('absences', function (Blueprint $table) {
            $table->unique(['employer_id', 'date']);
            $table->integer('original_heures')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
