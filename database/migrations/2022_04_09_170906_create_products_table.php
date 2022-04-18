<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('sku', 12);
            $table->text('description')->nullable();
            $table->string('size', 5);
            $table->string('color', 25);
            $table->integer('quantity');
            $table->double('price', 6, 2);
            $table->double('promotionalPrice', 6, 2)->nullable();
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('promotion_id')->nullable();
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
        Schema::dropIfExists('products');
    }
}
