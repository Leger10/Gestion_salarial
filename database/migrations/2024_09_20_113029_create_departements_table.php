<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartementsTable extends Migration
{
    public function up()
    {
        // Avant de créer la table, on vérifie qu'elle n'existe pas déjà
        if (!Schema::hasTable('departements')) {
            Schema::create('departements', function (Blueprint $table) {
                $table->id();
                $table->string('nom')->unique(); // empêche les doublons de noms
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('departements');
    }
}
