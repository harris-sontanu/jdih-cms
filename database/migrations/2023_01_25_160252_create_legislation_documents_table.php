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
        Schema::create('legislation_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legislation_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('media_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('type', ['master', 'abstract', 'attachment', 'cover']);
            $table->tinyInteger('order')->default(1);
            $table->integer('download')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legislation_documents');
    }
};
