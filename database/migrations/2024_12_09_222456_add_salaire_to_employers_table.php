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
        Schema::table('employers', function (Blueprint $table) {
            $table->decimal('salaire', 8, 2)->nullable();// Exemple d'ajout d'une colonne salaire avec un type decimal
        });
 
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            //
        });
    }
};
