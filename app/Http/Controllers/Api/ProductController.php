<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Hideyo\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
	public function index() {
		$products = Product::paginate(\Request::get('per_page'));
		return ProductResource::collection($products);
	}

	public function show($id) {
		$product = Product::find($id);
		return new ProductResource($product);
	}

	public function findByCategory($category_id) {
		$products = Product::where('product_category_id', '=', $category_id)->paginate(\Request::get('per_page'));
		return ProductResource::collection($products);
	}
}