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
        Schema::create('brain_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brain_id')->constrained('brains');
            $table->foreignId('opponent_id')->constrained('brains');
            $table->integer('brain_discs');
            $table->integer('opponent_discs');
            $table->boolean('is_first');
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
        Schema::dropIfExists('brain_records');
    }
};
