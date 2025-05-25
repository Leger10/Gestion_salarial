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
        Schema::table('salaries', function (Blueprint $table) {
            $table->string('departement')->nullable();  // Vous pouvez définir le type et la nullabilité selon vos besoins
        });
    }
    
    public function down()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropColumn('departement');
        });
    }
    
};
