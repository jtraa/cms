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
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('telephone');
            $table->string('email');
            $table->string('image')->nullable();
            $table->string('image_with_size')->nullable();
            $table->string('image_conversion')->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('about');
            $table->string('remember_token')->nullable();
            $table->mediumInteger('order');
            $table->dateTime('published_until')->nullable();
            $table->dateTime('published_at');
            $table->string('slug');
            $table->integer('in_index')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
