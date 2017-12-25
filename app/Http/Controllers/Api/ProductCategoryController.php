<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Hideyo\Models\Product;
use Hideyo\Models\ProductCategory;

class ProductCategoryController extends Controller
{
	public function index() {
		return [
			'data' => ProductCategory::all()
		];
	}

	public function show(ProductCategory $category) {
		return [
			'data' => $category
		];
	}

	public function products(ProductCategory $category) {
		// TODO: https://laravel.com/docs/5.5/eloquent-resources#pagination
		$data = Product::where('active', true)->where('product_category_id', $category->id)
				->with('productImages')
				->with('shop')
				->get();

		return [
			'data' => $data
		];
	}
}