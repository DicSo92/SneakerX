<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('tempConfirmation')->nullable()->default(true);
            $table->string('email');
            $table->bigInteger('totalPrice');
            $table->bigInteger('cardNumbers');
            $table->string('dateExp');
            $table->boolean('paymentStatus')->nullable()->default(true);
            $table->boolean('deliveryStatus')->nullable()->default(false);
            $table->foreignId('user_id')
                ->nullable()
                ->constrained();
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
        Schema::dropIfExists('orders');
    }
}
