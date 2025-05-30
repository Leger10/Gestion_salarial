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
        Schema::create('email', function (Blueprint $table) {
            $table->id();
            $table->string('email_address');
            $table->string('users');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('email');
    }
    
};
