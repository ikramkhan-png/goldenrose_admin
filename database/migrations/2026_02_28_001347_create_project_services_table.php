<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            // Polymorphic columns
            $table->string('service_type'); // full class name: App\Models\Machinery or App\Models\Manpower
            $table->unsignedBigInteger('service_id'); // references machineries or manpowers

            // Rate columns — nullable now
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->decimal('monthly_rate', 10, 2)->nullable();

            $table->integer('hours')->nullable();
            $table->integer('days')->nullable();
            $table->integer('months')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_services');
    }
};