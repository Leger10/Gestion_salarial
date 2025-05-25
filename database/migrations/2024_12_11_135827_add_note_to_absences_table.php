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
        Schema::table('absences', function (Blueprint $table) {
            $table->text('note')->nullable(); // Champ pour la justification, peut être nul
        });
    }
    
    public function down()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
    
};
