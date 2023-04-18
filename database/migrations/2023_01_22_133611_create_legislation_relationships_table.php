<?php

use App\Enums\LegislationRelationshipType;
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
        Schema::create('legislation_relationships', function (Blueprint $table) {
            $table->bigInteger('legislation_id')->unsigned();
            $table->bigInteger('related_to')->unsigned();
            $table->enum('type', LegislationRelationshipType::values());
            $table->string('status')->nullable();
            $table->text('note')->nullable();

            $table->primary(['legislation_id', 'related_to', 'type']);

            $table->foreign('legislation_id')->references('id')->on('legislations')->cascadeOnDelete();
            $table->foreign('related_to')->references('id')->on('legislations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legislation_relationships');
    }
};
