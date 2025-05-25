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
            $table->boolean('is_grayed_out')->default(false); // Ajoute le champ is_grayed_out
        });
    }

    public function down()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn('is_grayed_out'); // Retirer le champ en cas de rollback
        });
    }
    
};
