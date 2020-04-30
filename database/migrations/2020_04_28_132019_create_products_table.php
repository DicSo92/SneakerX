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
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('image')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->bigInteger('price')->nullable()->default(null);
            $table->boolean('active')->default(false);
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->text('refLink');
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
