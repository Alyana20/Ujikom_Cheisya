<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add missing payment tracking columns
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('paid_at');
            }
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            }
            if (!Schema::hasColumn('orders', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
            }
            // Add delivery details columns
            if (!Schema::hasColumn('orders', 'recipient_name')) {
                $table->string('recipient_name')->nullable()->after('cancelled_at');
            }
            if (!Schema::hasColumn('orders', 'recipient_phone')) {
                $table->string('recipient_phone')->nullable()->after('recipient_name');
            }
            if (!Schema::hasColumn('orders', 'delivery_address')) {
                $table->text('delivery_address')->nullable()->after('recipient_phone');
            }
            if (!Schema::hasColumn('orders', 'delivery_city')) {
                $table->string('delivery_city')->nullable()->after('delivery_address');
            }
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 12, 2)->default(0)->after('delivery_city');
            }
            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 12, 2)->default(0)->after('shipping_cost');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'paid_at',
                'shipped_at',
                'delivered_at',
                'cancelled_at',
                'recipient_name',
                'recipient_phone',
                'delivery_address',
                'delivery_city',
                'shipping_cost',
                'total_price'
            ]);
        });
    }
};
