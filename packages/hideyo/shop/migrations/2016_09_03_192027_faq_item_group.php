<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FaqItemGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the users table
        Schema::create('faq_item_group', function ($table) {
            $table->increments('id');
            $table->boolean('active')->default(false);
            $table->integer('rank')->default(0);
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');

            $table->string('slug');
            $table->integer('modified_by_user_id')->unsigned()->nullable();
            $table->foreign('modified_by_user_id')->references('id')->on('user')->onDelete('set null');
            $table->unique(array('title','shop_id'), 'unique_news_group_title');


            $table->timestamps();
        });


        Schema::table('faq_item', function (Blueprint $table) {
            $table->integer('faq_item_group_id')->unsigned()->nullable();
            $table->foreign('faq_item_group_id')->references('id')->on('faq_item_group')->onDelete('set null');
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
