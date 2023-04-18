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
        Schema::create('legislation_matter', function (Blueprint $table) {
            $table->bigInteger('legislation_id')->unsigned();
            $table->integer('matter_id')->unsigned();

            $table->foreign('legislation_id')->references('id')->on('legislations')->cascadeOnDelete();
            $table->foreign('matter_id')->references('id')->on('matters')->cascadeOnDelete();

            $table->primary(['legislation_id', 'matter_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legislation_matter');
    }
};
