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
        Schema::create('categories', function (Blueprint $table) {
            $table->integerIncrements('id')->unsigned();
            $table->tinyInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('abbrev')->nullable()->unique();
            $table->string('code')->nullable();
            $table->text('desc')->nullable();
            $table->integer('sort')->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('categories');
    }
};
