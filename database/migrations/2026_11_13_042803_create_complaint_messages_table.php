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
    Schema::create('complaint_messages', function (Blueprint $table) {
        $table->id();

        $table->foreignId('complaint_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->enum('sender_type', ['admin', 'complainant']);

        $table->text('message');

        $table->timestamp('read_at')->nullable();

        $table->timestamps();

        $table->index(['complaint_id', 'created_at']);
    });
}

public function down(): void
{
    Schema::dropIfExists('complaint_messages');
}

};
