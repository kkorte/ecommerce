<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SendingPaymentMethodRelatedTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sending_payment_method_related', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sending_method_id')->unsigned();
            $table->foreign('sending_method_id')->references('id')->on('sending_method')->onDelete('cascade');
            $table->integer('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('payment_method')->onDelete('cascade');
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->text('pdf_text')->nullable();
            $table->text('payment_text')->nullable();
            $table->text('payment_confirmed_text')->nullable();
            
            $table->timestamps();

            $table->unique(array('sending_method_id','payment_method_id'), 'unique_sending_payment_method_related');
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
