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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_saham');
            $table->integer('harga');
            $table->string('perubahan')->nullable();
            $table->timestamp('waktu_pembaruan')->nullable();
            $table->integer('pembukaan')->nullable();
            $table->integer('penutupan_sebelumnya')->nullable();
            $table->integer('offer')->nullable();
            $table->integer('bid')->nullable();
            $table->integer('harga_terendah')->nullable();
            $table->integer('harga_tertinggi')->nullable();
            $table->bigInteger('volume')->nullable();
            $table->bigInteger('nilai_transaksi')->nullable();
            $table->integer('frekuensi')->nullable();
            $table->integer('eps')->nullable();
            $table->float('pe_ratio')->nullable();
            $table->bigInteger('market_cap')->nullable();
            $table->string('peringkat_industri')->nullable();
            $table->string('peringkat_semua_perusahaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
