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
            $table->decimal('salaire_net', 8, 2)->nullable()->after('salaire'); // Ajouter salaire_net après la colonne salaire
        });
    }
    
    public function down()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('salaire_net'); // Supprimer la colonne si la migration est annulée
        });
    }
    
};
