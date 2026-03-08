<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('client_service_billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_service_id')
                  ->constrained('client_services')
                  ->onDelete('cascade');
            $table->decimal('amount_billed', 12, 2);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending','paid'])->default('pending');
            $table->string('invoice')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_service_billings');
    }
};