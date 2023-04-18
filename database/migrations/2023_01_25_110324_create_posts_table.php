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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('taxonomy_id')
                ->unsigned()
                ->nullable();
            $table->foreign('taxonomy_id')
                ->references('id')
                ->on('taxonomies')
                ->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt')->nullable();
            $table->mediumText('body');
            $table->tinyText('source')->nullable();
            $table->unsignedBigInteger('cover_id')
                ->nullable();
            $table->foreign('cover_id')
                ->references('id')
                ->on('media')
                ->nullOnDelete();
            $table->integer('view')->default(0);
            $table->bigInteger('author_id')
                ->unsigned()
                ->nullable();
            $table->foreign('author_id')
                ->references('id')
                ->on('employees')
                ->nullOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
