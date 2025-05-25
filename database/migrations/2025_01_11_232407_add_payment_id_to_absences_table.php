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
        $table->integer('payment_id')->nullable(); // Or change the type to match your needs
    });
}

public function down()
{
    Schema::table('absences', function (Blueprint $table) {
        $table->dropColumn('payment_id');
    });
}

};
