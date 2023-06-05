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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('tatra_podtatrze')->default(false);
            $table->boolean('tatra_slowackie')->default(false);
            $table->boolean('beskidy_zachodnie')->default(false);
            $table->boolean('beskidy_wschodnie')->default(false);
            $table->boolean('gory_swietokrzyskie')->default(false);
            $table->boolean('sudety')->default(false);
            $table->boolean('słowacja')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};