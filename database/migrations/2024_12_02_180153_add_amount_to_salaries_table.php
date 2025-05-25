<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountToSalariesTable extends Migration
{
    public function up()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->decimal('amount', 10, 2); // Exemple de type DECIMAL pour la colonne amount
        });
    }

    public function down()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
}
