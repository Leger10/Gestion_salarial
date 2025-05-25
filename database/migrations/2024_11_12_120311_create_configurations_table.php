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
        if (!Schema::hasTable('configurations')) {
            Schema::create('configurations', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['PAYMENT_DATE', 'APP_NAME', 'DEVELOPPER_NAME', 'WORKING_HOURS', 'ANOTHER'])
                      ->default('ANOTHER')
                      ->comment('table de configuration');
                $table->string('value');
                $table->timestamps();
            });
        }
    }
    
};
