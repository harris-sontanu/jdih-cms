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
        Schema::create('slides', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->tinyInteger('sort')->default(0);
            $table->string('header')->nullable();
            $table->string('subheader')->nullable();
            $table->text('desc')->nullable();
            $table->enum('position', ['top', 'center', 'bottom'])->default('top');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
};
