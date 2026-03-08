<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('client_services', function (Blueprint $table) {
            $table->string('rate_type')->nullable()->after('service_id'); // hourly, daily, monthly
            $table->integer('duration')->nullable()->after('rate_type');   // number of hours/days/months
            $table->decimal('rate', 15, 2)->nullable()->after('duration'); // rate value
        });
    }

    public function down(): void
    {
        Schema::table('client_services', function (Blueprint $table) {
            $table->dropColumn(['rate_type', 'duration', 'rate']);
        });
    }
};