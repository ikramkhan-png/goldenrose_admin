<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('project_documents', function (Blueprint $table) {

            // Description / Notes
            $table->text('description')->nullable()->after('title');

            // File meta
            $table->string('file_type')->nullable()->after('file');

            // Who uploaded
            $table->foreignId('uploaded_by')
                  ->nullable()
                  ->after('file')
                  ->constrained('users')
                  ->nullOnDelete();

            // Update info
            $table->date('update_date')->nullable()->after('uploaded_by');

            $table->enum('status', ['info', 'progress', 'completed'])
                  ->default('info')
                  ->after('update_date');
        });
    }

    public function down(): void
    {
        Schema::table('project_documents', function (Blueprint $table) {

            $table->dropForeign(['uploaded_by']);

            $table->dropColumn([
                'description',
                'file_type',
                'uploaded_by',
                'update_date',
                'status',
            ]);
        });
    }
};