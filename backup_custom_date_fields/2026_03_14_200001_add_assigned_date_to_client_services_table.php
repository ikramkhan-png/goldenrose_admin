<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_services', function (Blueprint $table) {
            $table->date('assigned_date')->nullable()->after('monthly_rate')->comment('Date when service was assigned to client');
            $table->index('assigned_date');
        });
    }

    public function down(): void
    {
        Schema::table('client_services', function (Blueprint $table) {
            $table->dropIndex(['assigned_date']);
            $table->dropColumn('assigned_date');
        });
    }
};
