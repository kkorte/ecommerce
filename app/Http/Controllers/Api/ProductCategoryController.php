<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Hideyo\Models\ProductCategory;
use App\Http\Resources\ProductCategoryResource;

class ProductCategoryController extends Controller
{
	public function index() {
		$categories = ProductCategory::paginate(\Request::get('per_page'));
		return ProductCategoryResource::collection($categories);
	}

	public function show($id) {
		$category = ProductCategory::find($id);
		return new ProductCategoryResource($category);
	}
}