<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('manpowers', function (Blueprint $table) {
            // Drop foreign key first (if exists)
            if (Schema::hasColumn('manpowers', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }

            // Add new columns (without adding service_type again)
            if (!Schema::hasColumn('manpowers', 'rate')) {
                $table->decimal('rate', 10, 2)->after('service_type');
            }

            if (!Schema::hasColumn('manpowers', 'status')) {
                $table->string('status')->default('available')->after('rate');
            }
        });
    }

    public function down()
    {
        Schema::table('manpowers', function (Blueprint $table) {
            // Rollback columns if needed
            if (Schema::hasColumn('manpowers', 'rate')) {
                $table->dropColumn('rate');
            }
            if (Schema::hasColumn('manpowers', 'status')) {
                $table->dropColumn('status');
            }
            if (!Schema::hasColumn('manpowers', 'service_id')) {
                $table->unsignedBigInteger('service_id')->after('id');
                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            }
        });
    }
};