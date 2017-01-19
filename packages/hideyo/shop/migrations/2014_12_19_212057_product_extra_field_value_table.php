<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductExtraFieldValueTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_extra_field_value', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            ;
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('extra_field_id')->unsigned()->nullable();
            ;
            $table->foreign('extra_field_id')->references('id')->on('extra_field')->onDelete('cascade');
            $table->integer('extra_field_default_value_id')->unsigned()->nullable();
            ;
            $table->foreign('extra_field_default_value_id')->references('id')->on('extra_field_default_value')->onDelete('set null');
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->timestamps();
            $table->unique(array('product_id','extra_field_id'), 'unique_product_extra_field_value');
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
