<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoAndDateNaissanceToClientsTable2025 extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('photo')->nullable();
        $table->date('date_naissance')->nullable();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['photo', 'date_naissance']);
    });
}

}
