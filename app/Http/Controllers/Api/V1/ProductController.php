<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    /**
     * Return the products.
     */
    public function index(Request $request): ResourceCollection
    {
        return ProductResource::collection(
            Product::search($request->all())->latest()->paginate(5)
        );
    }
}
