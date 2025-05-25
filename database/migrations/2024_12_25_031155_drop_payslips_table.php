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
        Schema::dropIfExists('payslips');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Si nécessaire, vous pouvez recréer la table ici.
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('overtime_pay', 8, 2);
            $table->timestamps();
        });
    }
};
