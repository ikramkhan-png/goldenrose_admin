<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('hiring_date')->nullable()->after('department_id')->comment('Date when employee was hired');
            $table->index('hiring_date');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['hiring_date']);
            $table->dropColumn('hiring_date');
        });
    }
};
