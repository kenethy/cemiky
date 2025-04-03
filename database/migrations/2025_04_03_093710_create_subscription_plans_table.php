<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // Nama service, misal: Netflix, WeTV, dll.
            $table->string('website')->nullable(); // URL menuju subscription plan asli
            $table->json('prices')->nullable(); // Menyimpan list harga dalam format JSON
            $table->string('logo')->nullable(); // Path ke logo atau ikon
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
