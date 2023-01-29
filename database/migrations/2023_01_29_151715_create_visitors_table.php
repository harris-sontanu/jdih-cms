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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ipv4');
            $table->integer('hits')->default(0);
            $table->string('page');
            $table->string('browser')->nullable();
            $table->boolean('mobile')->default(0);
            $table->string('platform')->nullable();
            $table->string('version')->nullable();
            $table->string('robot')->nullable();
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
        Schema::dropIfExists('visitors');
    }
};
