<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('short_title', 30)->nullable();
            $table->string('contact_email', 50)->nullable();
            $table->string('feedback_email', 50)->nullable();
            $table->string('mobile1', 30)->nullable();
            $table->string('mobile2', 30)->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_small')->nullable();
            $table->string('favicon')->nullable();
            $table->text('address')->nullable();
            $table->string('developed_by')->nullable();
            $table->string('developed_by_url')->nullable();
            $table->string('web')->nullable();
            $table->text('fb')->nullable();
            $table->text('tw')->nullable();
            $table->text('ln')->nullable();
            $table->text('yt')->nullable();
            $table->text('map')->nullable();
            $table->tinyInteger('is_meta')->default(0);
            $table->longText('meta')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
}
