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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('picture')->nullable();
            $table->string('nip')->nullable();
            $table->string('rank')->nullable();
            $table->integer('sort')->default(0);
        });

        Schema::create('employee_taxonomy', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedInteger('taxonomy_id');
            $table->primary(['employee_id', 'taxonomy_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_taxonomy');
    }
};
