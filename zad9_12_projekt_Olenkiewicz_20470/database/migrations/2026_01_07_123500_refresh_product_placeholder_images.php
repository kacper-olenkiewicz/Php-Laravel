<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Product::withoutEvents(function () {
            Product::query()
                ->whereNull('image_path')
                ->orWhere('image_path', 'like', 'https://images.unsplash.com%')
                ->chunkById(100, function ($products) {
                    foreach ($products as $product) {
                        $product->forceFill([
                            'image_path' => Product::placeholderImageFor($product->id),
                        ])->saveQuietly();
                    }
                });
        });
    }

    public function down(): void
    {
        // No rollback needed
    }
};
