<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Log;


class relatedProductService {

    public static function relatedProductQuery($categoryId): object {
        Log::info("Fetching related products for category ID: $categoryId");

        $relatedProducts = Product::where('category_id', $categoryId)
            ->take(15)
            ->with('offer:id,discount,type,start_date,expire_date,status')
            ->get(['id', 'slug', 'name', 'image', 'sale_price']);

        Log::info("Related products found: " . $relatedProducts->count());

        return $relatedProducts;
    }
}
