<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->mediumInteger('order');
            $table->unsignedBigInteger('filament_page_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('article_id')->nullable();
            $table->boolean('fixed_section')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
