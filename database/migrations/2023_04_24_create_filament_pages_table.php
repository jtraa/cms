<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filament_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->string('title');
            $table->longText('data')->nullable();
            $table->dateTime('published_at');
            $table->dateTime('published_until')->nullable();
            $table->timestamps();
            $table->integer('order');
            $table->softDeletes();
            $table->boolean('in_menu')->default(0);
            $table->boolean('fixed_page')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filament_pages');
    }
};
