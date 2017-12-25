<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Hideyo\Models\Product;

class ProductController extends Controller
{
	public function index() {
		// TODO: https://laravel.com/docs/5.5/eloquent-resources#pagination
		$data = Product::with('productImages')
				->with('shop')
				->get();

		return [
			'data' => $data
		];
	}

	public function show($id) {
		$data = Product::where('id', $id)
			->with('productImages')
			->with('shop')
			->with('productCategory')
			->first();

		return [
			'data' => $data
		];
	}
}