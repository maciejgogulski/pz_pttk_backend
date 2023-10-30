<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string("name")->default('Nowa odznaka');;
            $table->integer("point_threshold")->default(0);
            $table->unsignedBigInteger("next_badge")->nullable();
            $table->unsignedBigInteger("previous_badge")->nullable();
            $table->foreign('next_badge')->references('id')->on('badges')->onDelete('cascade');
            $table->foreign('previous_badge')->references('id')->on('badges')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
