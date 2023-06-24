<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThemeOptionSocialMediaToSiteOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_options', function (Blueprint $table) {
            $table->text('theme_option_social_media')->nullable()->after('theme_option_footer');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_options', function (Blueprint $table) {
            //
        });
    }
}
