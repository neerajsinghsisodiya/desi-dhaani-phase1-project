<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('orders', 'stripe_session_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('stripe_session_id', 'razorpay_order_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'razorpay_order_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('razorpay_order_id', 'stripe_session_id');
            });
        }
    }
};
