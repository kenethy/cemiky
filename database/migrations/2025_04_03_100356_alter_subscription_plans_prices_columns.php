<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Jika kolom 'prices' masih ada, hapus terlebih dahulu
            if (Schema::hasColumn('subscription_plans', 'prices')) {
                $table->dropColumn('prices');
            }
            // Tambahkan kolom baru untuk monthly dan yearly price
            $table->string('monthly_price')->nullable()->after('website');
            $table->string('yearly_price')->nullable()->after('monthly_price');
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Jika rollback, hapus kolom baru dan bisa menambahkan kembali kolom prices (opsional)
            $table->dropColumn(['monthly_price', 'yearly_price']);
            // Opsional: tambahkan kembali kolom 'prices'
            // $table->json('prices')->nullable()->after('website');
        });
    }
};
