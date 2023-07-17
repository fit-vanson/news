<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackNewsUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_news_urls', function (Blueprint $table) {
            $table->id();
            $table->integer('news_id')->index();
            $table->boolean('is_robot');
            $table->text('robot');
            $table->string('ip_address');
            $table->string('device_name');
            $table->string('device_name_full');
            $table->string('platform_name');
            $table->string('country');
            $table->integer('count')->default(0);
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
        Schema::dropIfExists('track_news_urls');
    }
}
