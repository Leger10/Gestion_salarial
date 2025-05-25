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
        $table->integer('heures')->after('date');  // Ajout de la colonne heures
    });
}

public function down()
{
    Schema::table('absences', function (Blueprint $table) {
        $table->dropColumn('heures');  // Suppression de la colonne heures
    });
}
};