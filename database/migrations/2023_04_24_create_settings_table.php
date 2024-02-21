<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('companyname')->nullable();
            $table->string('address')->nullable();
            $table->string('housenumber')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('kvk')->nullable();
            $table->string('btw')->nullable();
            $table->string('websitename')->nullable();
            $table->string('description')->nullable();
            $table->string('linkedinlink')->nullable();
            $table->string('instagramlink')->nullable();
            $table->string('facebooklink')->nullable();
            $table->string('googlemapslink')->nullable();
            $table->string('recaptchakey')->nullable();
            $table->string('image')->nullable();
            $table->string('image_with_size')->nullable();
            $table->string('image_conversion')->nullable();
            $table->string('footertext')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('employees');
    }
};
