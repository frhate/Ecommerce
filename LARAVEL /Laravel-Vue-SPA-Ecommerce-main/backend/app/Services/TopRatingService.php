<?php

namespace App\Services;

use App\Http\Resources\Api\Frontend\ProductResource;
use Illuminate\Support\Facades\DB;

class TopRatingService {

    /**
     * Get Top rating products without offer details.
     */
    public static function topRatingsQuery(): object {
        $products = DB::table('products')
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->leftJoin('offers', 'products.offer_id', '=', 'offers.id')
            ->selectRaw('count(reviews.product_id) as p_id_count, avg(rating_value) as rating, products.id as p_id, products.sale_price, products.slug, products.sku, products.image, products.created_at, offers.discount, offers.type')
            ->groupBy('products.id', 'products.sale_price', 'products.slug', 'products.sku', 'products.image', 'products.created_at', 'offers.discount', 'offers.type') // Include all selected columns in the GROUP BY clause
            ->orderByDesc('products.created_at')
            ->paginate(12);

        return ProductResource::collection($products);
    }

}
