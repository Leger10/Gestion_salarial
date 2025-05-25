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
            $table->decimal('heures_supplementaires', 8, 2)->default(0); // Pour les heures supplémentaires
            $table->boolean('is_grayed_out')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('heures_supplementaires');
           
        });
    }
  
};
