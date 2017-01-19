<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SendingMethodTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sending_method', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(false);
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
            $table->string('title');
            $table->decimal('price', 12, 4)->nullable();
            $table->decimal('no_price_from', 12, 4)->nullable();
            $table->decimal('minimal_weight', 12, 4)->nullable();
            $table->decimal('maximal_weight', 12, 4)->nullable();
            $table->integer('tax_rate_id')->unsigned()->nullable();
            $table->foreign('tax_rate_id')->references('id')->on('tax_rate')->onDelete('set null');
            $table->enum('total_price_discount_type', array('amount', 'percent'));
            $table->decimal('total_price_discount_value', 12, 4)->nullable();
            $table->date('total_price_discount_start_date')->nullable();
            $table->date('total_price_discount_end_date')->nullable();
            
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->timestamps();

            $table->unique(array('title','shop_id'), 'unique_sending_method_title');
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
