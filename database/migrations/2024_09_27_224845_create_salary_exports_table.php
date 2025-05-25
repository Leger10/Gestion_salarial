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
        Schema::create('salary_exports', function (Blueprint $table) {
            $table->id();
            $table->string('employers_name');
            $table->decimal('salary_amount', 15, 2);
            $table->date('export_date');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_exports');
    }
};
