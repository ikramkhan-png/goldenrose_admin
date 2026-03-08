<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_billings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->decimal('amount_billed', 12, 2);
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->date('payment_date')->nullable();

            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->string('invoice')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_billings');
    }
};