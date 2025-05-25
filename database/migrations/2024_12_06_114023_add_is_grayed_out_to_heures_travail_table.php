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
        Schema::table('heures_travail', function (Blueprint $table) {
            $table->boolean('is_grayed_out')->default(false); // Vous pouvez ajuster le type et la valeur par défaut selon vos besoins
        });
    }
    
    public function down()
    {
        Schema::table('heures_travail', function (Blueprint $table) {
            $table->dropColumn('is_grayed_out');
        });
    }
    
};
