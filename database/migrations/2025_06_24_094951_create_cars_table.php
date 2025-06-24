<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client::class)->constrained();
            $table->enum('type', ['TGK', 'SZGK', 'SPORT']);
            $table->timestamp('registered');
            $table->boolean('ownbrand');
            $table->unsignedInteger('accidents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
