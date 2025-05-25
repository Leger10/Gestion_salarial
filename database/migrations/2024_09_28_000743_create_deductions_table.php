<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration
{
    public function up()
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
        });
    } 

    public function down()
    {
        Schema::dropIfExists('deductions'); // Supprime la table si elle existe
    }
}
