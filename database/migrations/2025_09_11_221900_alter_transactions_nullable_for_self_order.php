<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Make cashier_id and payment_method nullable for self-order pending transactions
        // Use raw SQL to avoid requiring doctrine/dbal for column changes.
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE transactions MODIFY cashier_id BIGINT UNSIGNED NULL');
            DB::statement('ALTER TABLE transactions MODIFY payment_method VARCHAR(255) NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE transactions ALTER COLUMN cashier_id DROP NOT NULL');
            DB::statement('ALTER TABLE transactions ALTER COLUMN payment_method DROP NOT NULL');
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            // Revert to NOT NULL with a default empty string for safety (adjust as needed)
            DB::statement('ALTER TABLE transactions MODIFY cashier_id BIGINT UNSIGNED NOT NULL');
            DB::statement("ALTER TABLE transactions MODIFY payment_method VARCHAR(255) NOT NULL");
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE transactions ALTER COLUMN cashier_id SET NOT NULL');
            DB::statement('ALTER TABLE transactions ALTER COLUMN payment_method SET NOT NULL');
        }
    }
};
