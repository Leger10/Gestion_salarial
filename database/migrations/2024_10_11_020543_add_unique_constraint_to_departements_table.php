<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     // Vérifie si l'index 'departements_nom_unique' n'existe pas déjà
    //     $schemaManager = Schema::getConnection()->getDoctrineSchemaManager();
    //     $indexes = $schemaManager->listTableIndexes('departements');

    //     if (!array_key_exists('departements_nom_unique', $indexes)) {
    //         Schema::table('departements', function (Blueprint $table) {
    //             $table->unique('nom', 'departements_nom_unique');
    //         });
    //     }
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('departements', function (Blueprint $table) {
    //         $table->dropUnique('departements_nom_unique');
    //     });
    // }
};
