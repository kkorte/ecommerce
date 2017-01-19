<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the users table
        Schema::create('product', function ($table) {
            $table->increments('id');
            $table->boolean('active')->default(false);
            $table->enum('type', array('single', 'group', 'variation'));
            $table->integer('product_category_id')->unsigned()->nullable();
            ;
            $table->foreign('product_category_id')->references('id')->on('product_category')->onDelete('set null');
            $table->string('reference_code')->nullable();

            $table->string('ean_code')->nullable();
            $table->string('mpn_code')->nullable();
            
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->decimal('price', 12, 4)->nullable();
            $table->decimal('cost_price', 12, 4)->nullable();
            $table->decimal('commercial_price', 12, 4)->nullable();
            $table->boolean('discount_promotion')->default(true);

            $table->enum('discount_type', array('amount', 'percent'));
            $table->decimal('discount_value', 12, 4)->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();


            $table->bigInteger('amount')->default(0);
            $table->bigInteger('weight')->default(0);
            $table->integer('tax_rate_id')->unsigned()->nullable();
            $table->foreign('tax_rate_id')->references('id')->on('tax_rate')->onDelete('set null');
            $table->unsignedInteger('product_parent_id')->nullable();
            $table->foreign('product_parent_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('rank')->default(0);
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
            $table->string('slug');
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->unique(array('title','shop_id'), 'unique_product_title');
            $table->timestamps();
        });


        Schema::create('product_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('product_variation_id')->unsigned()->nullable();
            $table->foreign('product_variation_id')->references('id')->on('product')->onDelete('set null');
            $table->string('file')->nullable();
            $table->string('path')->nullable();
            $table->integer('size')->nullable();
            $table->string('extension')->nullable();
            $table->integer('rank')->default(0);
            $table->string('tag')->nullable();
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->timestamps();
        });


        Schema::create('product_related_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->integer('related_product_id')->unsigned();
            $table->foreign('related_product_id')->references('id')->on('product')->onDelete('cascade');
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
