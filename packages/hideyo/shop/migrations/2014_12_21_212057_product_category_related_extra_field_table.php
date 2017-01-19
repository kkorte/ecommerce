<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductCategoryRelatedExtraFieldTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category_related_extra_field', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('extra_field_id')->unsigned()->nullable();
            ;
            $table->foreign('extra_field_id')->references('id')->on('extra_field')->onDelete('cascade');
            $table->integer('product_category_id')->unsigned()->nullable();
            ;
            $table->foreign('product_category_id')->references('id')->on('product_category')->onDelete('cascade');
            
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
