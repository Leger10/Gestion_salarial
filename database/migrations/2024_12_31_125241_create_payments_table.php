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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
        
            // Salary related information
           $table->decimal('montant_journalier', 10, 2)->nullable();
            $table->unsignedInteger('heures_travail');
            $table->unsignedInteger('heures_totales');
            $table->unsignedInteger('heures_absence');
            $table->decimal('salaire_total_avant_taxes', 10, 2);
            $table->decimal('taxe', 10, 2);
            $table->decimal('salaire_net', 10, 2);
            
            // Payment related information
            $table->dateTime('launch_date');
            $table->dateTime('done_time');
            
            // Payment status
            $table->enum('status', ['SUCCESS', 'FAILED'])->default('SUCCESS');
            
            // Month and year of payment
            $table->enum('month', [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ])->nullable();
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
