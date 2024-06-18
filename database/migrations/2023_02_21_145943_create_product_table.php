<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        |--------------------------------------------------------------------------
        | Adding foreign key
        |--------------------------------------------------------------------------
        |
        | I am adding a foreign key to type_id field.
        | Here, products_type table id field has biginteger datatype
        |
        |--------------------------------------------------------------------------
        | Values
        |--------------------------------------------------------------------------
        |
        | foreign() – Pass field name which you want to foreign key constraint.
        | references() – Pass linking table field name.
        | on() – Linking table name.
        | onDelete(‘cascade’) – Enable deletion of attached data.
        */
        Schema::create('product', function (Blueprint $table) {

            $table->increments('id', true); //Prmiary

            $table->integer('type_id')->index()->unsigned(); //Forgien
            $table->foreign('type_id')->references('id')->on('products_type')->onDelete('cascade');

            $table->integer('category_id')->index()->unsigned(); //Forgien
            $table->foreign('category_id')->references('id')->on('products_category')->onDelete('cascade');

            $table->integer('brand_id')->index()->unsigned(); //Forgien
            $table->foreign('brand_id')->references('id')->on('products_brand')->onDelete('cascade');

            $table->string('code',50)->unique()->nullable();
            $table->string('name', 150)->default('');
            $table->string('image', 500)->nullable();
            $table->string('cover',500)->nullable();
            $table->string('size',50)->nullable();
            $table->double('unit_price')->default(0);
            $table->boolean('is_available')->default(0);

            $table->integer('quantity')->default(0);
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();

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
        Schema::dropIfExists('product');
    }
}
