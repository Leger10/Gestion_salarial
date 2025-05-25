<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('reset_code_passwords', function (Blueprint $table) {
        $table->id();
        $table->string('code');
        $table->string('email')->nullable();
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('reset_code_passwords'); // Suppression de la table en cas de rollback
    }
};
