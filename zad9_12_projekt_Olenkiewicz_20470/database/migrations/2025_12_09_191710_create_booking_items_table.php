<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price_per_day', 8, 2);
            $table->integer('days');
            $table->timestamps();
            $table->unique(['booking_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};