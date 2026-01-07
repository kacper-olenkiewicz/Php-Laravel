<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('rental_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
        });

        $payments = DB::table('payments')
            ->join('bookings', 'bookings.id', '=', 'payments.booking_id')
            ->select('payments.id', 'bookings.rental_id')
            ->whereNull('payments.rental_id')
            ->get();

        foreach ($payments as $payment) {
            DB::table('payments')
                ->where('id', $payment->id)
                ->update(['rental_id' => $payment->rental_id]);
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropConstrainedForeignId('rental_id');
        });
    }
};
