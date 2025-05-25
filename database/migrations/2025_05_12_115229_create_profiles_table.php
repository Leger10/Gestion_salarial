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
        Schema::create('profiles', function (Blueprint $table) { 
            $table->id(); // Ou $table->uuid('id')->primary() pour UUID 
$table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relation One-to-One
$table->string('adresse')->nullable(); 
            $table->string('phone')->nullable(); 
            $table->string('photo')->nullable(); // Chemin vers la photo 
            $table->timestamps(); 
        }); 
    } 
  
    /** 
     * Reverse the migrations. 
     */ 
    public function down(): void 
    { 
        Schema::dropIfExists('profiles'); 
    }
};
