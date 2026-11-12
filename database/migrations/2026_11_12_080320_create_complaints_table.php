<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            // Identitas pelapor
            $table->string('ticket_number')->unique();
            $table->string('access_code_hash');
            $table->string('name');
            $table->string('nik', 16);
            $table->string('phone');
            $table->string('email')->nullable();

            // Lokasi pelayanan
            $table->string('service_location');
            $table->string('other_location')->nullable();

            // Isi pengaduan
            $table->string('category');
            $table->text('description');

            // Tindak lanjut
            $table->enum('status', [
                'Baru',
                'Diproses',
                'Menunggu Balasan',
                'Selesai',
                'Dicabut'
            ])->default('Baru');

            $table->text('withdrawal_reason')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('nik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
