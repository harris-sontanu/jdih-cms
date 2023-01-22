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
        Schema::create('legislations', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')
                ->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->cascadeOnDelete();
            $table->string('title', 767);
            $table->string('slug', 767);
            $table->string('code_number')->nullable();
            $table->integer('number')->nullable();
            $table->smallInteger('year')->nullable();
            $table->string('call_number')->nullable();
            $table->string('edition')->nullable();
            $table->string('place')->nullable();
            $table->string('location')->nullable();
            $table->date('approved')->nullable();
            $table->date('published')->nullable();
            $table->string('publisher')->nullable();
            $table->text('source')->nullable();
            $table->text('subject')->nullable();
            $table->integer('institute_id')
                ->unsigned()
                ->nullable();
            $table->foreign('institute_id')
                ->references('id')
                ->on('institutes')
                ->nullOnDelete();
            $table->integer('field_id')
                ->unsigned()
                ->nullable();
            $table->foreign('field_id')
                ->references('id')
                ->on('fields')
                ->nullOnDelete();
            $table->string('status')->nullable();
            $table->string('language')->nullable();
            $table->string('author')->nullable();
            $table->string('signer')->nullable();
            $table->text('note')->nullable();
            $table->text('desc')->nullable();
            $table->string('isbn')->nullable();
            $table->string('index_number')->nullable();
            $table->string('justice')->nullable();
            $table->integer('view')->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();;
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
        Schema::dropIfExists('legislations');
    }
};
