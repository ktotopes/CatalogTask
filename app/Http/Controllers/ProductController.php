<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductValidationRequest;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{

    public function index(ProductValidationRequest $request)
    {
        $filter = $request->get('filter') ?? [];

        return response()->json([
            'products' => Product::query()
                ->where(function (Builder $query) use ($filter) {
                    if (isset($filter['categories'])){
                        $query->whereIn('category_id', $filter['categories']);
                    }

                    foreach (['width', 'length', 'the_weight'] as $key) {
                        if (isset($filter[$key])) {
                            $query->where($key, '>=', $filter[$key]);
                        }
                    }

                    $query
                        ->where('price', '>=', $filter['min_price'] ?? 0)
                        ->where('price', '<=', $filter['max_price'] ?? 10**10);

                    return $query;
                })
                ->get(),
        ]);
    }


    public function show(Product $product)
    {
        return response()->json([
            'product' => $product,
        ]);
    }

}
