<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource; // Będziesz musiał stworzyć

class ProductApiController extends Controller
{
    // Publiczny dostęp do listy produktów
    public function index(Request $request)
    {
        $products = Product::where('stock_quantity', '>', 0)
                            ->filter($request->only('search', 'category')) // Załóżmy, że Product ma scopeFilter
                            ->paginate(20);

        // Zwracanie kolekcji zasobów API
        return ProductResource::collection($products);
    }
}