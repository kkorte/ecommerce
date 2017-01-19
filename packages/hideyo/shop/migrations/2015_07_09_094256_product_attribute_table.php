<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductAttributeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('default_on')->default(false);
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->string('reference_code');
            $table->decimal('price', 12, 4)->nullable();
            $table->decimal('commercial_price', 12, 4)->nullable();
            $table->decimal('cost_price', 12, 4)->nullable();            
            $table->bigInteger('amount')->default(0);
            $table->integer('tax_rate_id')->unsigned()->nullable();
            $table->foreign('tax_rate_id')->references('id')->on('tax_rate')->onDelete('set null');
            $table->boolean('discount_promotion')->default(true);
            $table->enum('discount_type', array('amount', 'percent'));
            $table->decimal('discount_value', 12, 4)->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('product_attribute_combination', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_attribute_id')->unsigned();
            $table->foreign('product_attribute_id')->references('id')->on('product_attribute')->onDelete('cascade');
            $table->integer('attribute_id')->unsigned();
            $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade');
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('product_attribute_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_attribute_id')->unsigned();
            $table->foreign('product_attribute_id')->references('id')->on('product_attribute')->onDelete('cascade');
            $table->integer('product_image_id')->unsigned();
            $table->foreign('product_image_id')->references('id')->on('product_image')->onDelete('cascade');
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->timestamps();
        });

        Schema::table('product', function (Blueprint $table) {
            $table->integer('leading_atrribute_group_id')->unsigned()->nullable();
            $table->foreign('leading_atrribute_group_id')->references('id')->on('attribute_group')->onDelete('set null');
        });
        


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     //
    }
}
