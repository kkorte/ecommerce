<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderSendingMethodTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sending_method', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->integer('sending_method_id')->unsigned()->nullable();
            $table->foreign('sending_method_id')->references('id')->on('sending_method')->onDelete('set null');
            $table->string('title');
            $table->decimal('price_with_tax', 12, 4)->nullable();
            $table->decimal('price_without_tax', 12, 4)->nullable();
            $table->bigInteger('weight')->nullable();
            $table->decimal('tax_rate', 12, 4)->nullable();
            $table->integer('tax_rate_id')->unsigned()->nullable();
            $table->foreign('tax_rate_id')->references('id')->on('tax_rate')->onDelete('set null');
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
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
