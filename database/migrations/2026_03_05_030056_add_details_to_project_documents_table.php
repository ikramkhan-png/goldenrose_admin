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
        Schema::table('project_documents', function (Blueprint $table) {
            // user_id links to the person logged in
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            // document_type (e.g., PDF, Image, Contract)
            $table->string('document_type')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('project_documents', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'document_type']);
        });
    }

};
