<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductWaitinglistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_waiting_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('product_attribute_id')->unsigned()->nullable();
            $table->foreign('product_attribute_id')->references('id')->on('product_attribute')->onDelete('set null');
            $table->string('email')->nullable();
            $table->unique(array('product_id', 'product_attribute_id', 'email'), 'unique_product_waitinglist');
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
        //
    }
}
