<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'image_path')) {
                $table->string('image_path')->nullable()->after('description');
            }
        });

        if (! Schema::hasColumn('products', 'image_path')) {
            return;
        }

        $placeholders = [
            'https://images.unsplash.com/photo-1529429617124-aee711a70412?auto=format&fit=crop&w=600&h=400&q=80',
            'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=600&h=400&q=80',
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&h=400&q=80',
            'https://images.unsplash.com/photo-1485960994840-902a67e187c8?auto=format&fit=crop&w=600&h=400&q=80',
            'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=600&h=400&q=80',
            'https://images.unsplash.com/photo-1432753759888-b30b2bdac995?auto=format&fit=crop&w=600&h=400&q=80',
            'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=600&h=400&q=80',
            'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&w=600&h=400&q=80',
        ];

        $count = count($placeholders);
        if ($count === 0) {
            return;
        }

        $products = DB::table('products')->select('id')->whereNull('image_path')->get();

        foreach ($products as $product) {
            $image = $placeholders[$product->id % $count];
            DB::table('products')
                ->where('id', $product->id)
                ->update(['image_path' => $image]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }
};
