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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'submitted', 'cancel'])->default('pending');
            $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete();
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('total');
            $table->foreignId('staff_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->dateTime('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
