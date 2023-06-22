<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_options', function (Blueprint $table) {
            $table->id();
            $table->integer('site_id')->index();
            $table->text('general_settings')->nullable();
            $table->text('mail_settings')->nullable();
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
            $table->text('theme_option_seo')->nullable();
            $table->text('theme_logo')->nullable();
            $table->text('facebook')->nullable();
            $table->text('twitter')->nullable();
            $table->text('whatsapp')->nullable();
            $table->text('currency')->nullable();
            $table->text('theme_option_header')->nullable();
            $table->text('theme_option_footer')->nullable();
            $table->text('home-video')->nullable();
            $table->text('facebook-pixel')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('google_tag_manager')->nullable();
            $table->text('cash_on_delivery')->nullable();
            $table->text('bank_transfer')->nullable();
            $table->text('stripe')->nullable();
            $table->text('mailchimp')->nullable();
            $table->text('subscribe_popup')->nullable();
            $table->text('seller_settings')->nullable();
            $table->text('language_switcher')->nullable();
            $table->text('paypal')->nullable();
            $table->text('razorpay')->nullable();
            $table->text('mollie')->nullable();
            $table->text('page_variation')->nullable();
            $table->text('google_map')->nullable();
            $table->text('theme_color')->nullable();
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
        Schema::dropIfExists('site_options');
    }
}
