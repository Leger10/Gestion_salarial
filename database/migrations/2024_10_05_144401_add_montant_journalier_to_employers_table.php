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
    if (!Schema::hasColumn('employers', 'montant_journalier')) {
        Schema::table('employers', function (Blueprint $table) {
            $table->decimal('montant_journalier', 12, 2)->after('phone');
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            // Supprime la colonne 'montant_journalier'
            $table->dropColumn('montant_journalier');
        });
    }
};
