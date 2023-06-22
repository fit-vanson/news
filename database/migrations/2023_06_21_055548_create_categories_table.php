<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('site_id');
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->text('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->integer('is_publish')->default(1);

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
        Schema::dropIfExists('categories');
    }
}
