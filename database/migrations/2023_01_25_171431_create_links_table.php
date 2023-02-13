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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('desc')->nullable();
            $table->string('url');
            $table->integer('sort')->default(0);
            $table->enum('type', ['banner', 'jdih', 'youtube']);
            $table->enum('display', ['main', 'aside', 'popup'])
                ->nullable();
            $table->bigInteger('user_id')
                ->unsigned()
                ->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
};
