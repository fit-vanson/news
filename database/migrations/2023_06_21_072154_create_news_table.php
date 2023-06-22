<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('category_id');
            $table->integer('user_id');

            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->text('thumbnail')->nullable();

            $table->integer('is_publish')->default(1);
            $table->integer('breaking_news')->default(0);

            $table->text('og_title')->nullable();
            $table->text('og_image')->nullable();
            $table->text('og_description')->nullable();
            $table->text('og_keywords')->nullable();
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
        Schema::dropIfExists('news');
    }
}
