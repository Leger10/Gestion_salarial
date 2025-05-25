<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employer_id');
            $table->decimal('montant', 10, 2); // Montant du salaire
            $table->decimal('salaire_net', 10, 2)->nullable(); 
            $table->integer('mois');  // Mois du salaire
            $table->integer('annee'); // Année du salaire
            $table->timestamps();

            // Clé étrangère vers la table employers
            $table->foreign('employer_id')->references('id')->on('employers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
