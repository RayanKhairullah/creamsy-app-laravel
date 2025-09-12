<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'source')) {
                $table->string('source')->default('pos')->index();
            }
            if (!Schema::hasColumn('transactions', 'customer_name')) {
                $table->string('customer_name')->nullable();
            }
            if (!Schema::hasColumn('transactions', 'table_code')) {
                $table->string('table_code')->nullable()->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'source')) {
                $table->dropColumn('source');
            }
            if (Schema::hasColumn('transactions', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
            if (Schema::hasColumn('transactions', 'table_code')) {
                $table->dropColumn('table_code');
            }
        });
    }
};
