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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description")->nullable();
            $table->foreignId("mountain_range_id")->constrained();
            $table->integer("badge_points_a_to_b");
            $table->integer("badge_points_b_to_a");
            $table->unsignedBigInteger('terrain_point_a_id');
            $table->unsignedBigInteger('terrain_point_b_id');
            $table->foreign('terrain_point_a_id')->references('id')->on('terrain_points')->onDelete('cascade');
            $table->foreign('terrain_point_b_id')->references('id')->on('terrain_points')->onDelete('cascade');
            $table->json('intermediate_points')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
