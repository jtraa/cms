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
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('slug')->nullable();
            $table->text('title')->nullable();
            $table->text('data')->nullable();
            $table->text('published_at')->nullable();
            $table->text('published_until')->nullable();
            $table->string('image')->nullable();
            $table->string('image_with_size')->nullable();
            $table->string('image_conversion')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();
            $table->integer('order')->nullable();
            $table->text('deleted_at')->nullable();
            $table->text('author')->nullable();
            $table->integer('in_index')->nullable();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};



