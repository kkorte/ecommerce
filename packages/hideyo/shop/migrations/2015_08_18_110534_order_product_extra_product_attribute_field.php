<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderProductExtraProductAttributeField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->string('reference_code')->nullable();
            $table->string('product_attribute_title')->nullable();
            $table->integer('product_attribute_id')->unsigned()->nullable();
            $table->foreign('product_attribute_id')->references('id')->on('product_attribute')->onDelete('set null');
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
