<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {

            $table->increments('id', true);

            $table->integer('cashier_id')->index()->unsigned()->nullable();
            $table->integer('customer_id')->index()->unsigned()->nullable();

            $table->integer('status_id')->index()->unsigned();
            $table->foreign('status_id')->references('id')->on('orders_status')->onDelete('cascade');

            $table->integer('type_id')->index()->unsigned();
            $table->foreign('type_id')->references('id')->on('orders_type')->onDelete('cascade');


            $table->integer('receipt_number')->unsigned();
            $table->double('total_price')->nullable();
            $table->double('discount')->nullable();

            $table->dateTime('ordered_at')->nullable();
            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
