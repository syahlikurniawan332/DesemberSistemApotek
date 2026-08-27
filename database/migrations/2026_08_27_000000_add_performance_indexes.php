<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->index(
                ['medicine_id', 'tanggal_kadaluarsa', 'stok'],
                'batches_medicine_expiry_stock_index'
            );
            $table->index(
                ['tanggal_kadaluarsa', 'stok'],
                'batches_expiry_stock_index'
            );
            $table->index('tanggal_masuk', 'batches_entry_date_index');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index(
                ['user_id', 'created_at'],
                'transactions_user_created_index'
            );
            $table->index('created_at', 'transactions_created_index');
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->index('kategori', 'medicines_category_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'users_role_index');
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropIndex('batches_medicine_expiry_stock_index');
            $table->dropIndex('batches_expiry_stock_index');
            $table->dropIndex('batches_entry_date_index');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('transactions_user_created_index');
            $table->dropIndex('transactions_created_index');
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->dropIndex('medicines_category_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_index');
        });
    }
};
