<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('sub_category_id')->unsigned();
            $table->string('title');
            $table->longText('content');
            $table->integer('num_visit')->unsigned()->default(0);
            $table->integer('num_like')->unsigned()->default(0);
            $table->integer('num_dislike')->unsigned()->default(0);
            $table->integer('num_comment')->unsigned()->default(0);
            $table->string('image');
            $table->boolean('published');
            $table->boolean('active')->default(1);
            $table->softDeletes();
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
        Schema::drop('articles');
    }
}
