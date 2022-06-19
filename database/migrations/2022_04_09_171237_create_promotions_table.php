<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->float('value');
            $table->enum('value_type', ['percent', 'monetary'])->default('percent');
            $table->enum('frequency', ['single', 'weekly', 'monthly', 'annual'])->default('single');
            $table->enum('price_field', ['price', 'promotional_price', 'both'])->default('promotional_price');
            $table->enum('change', ['increase', 'decrease'])->default('decrease');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
