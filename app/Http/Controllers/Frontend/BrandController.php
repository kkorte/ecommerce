<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Dutchbridge\Repositories\BrandRepositoryInterface;
use Dutchbridge\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(BrandRepositoryInterface $brand, ProductRepositoryInterface $product)
    {
        $this->brand = $brand;
        $this->product = $product;
        $this->shopId = config()->get('app.shop_id');
    }

    public function getIndex(Request $request)
    {
        $page = $request->get('page', 1);
        $brands = $this->brand->selectAllByShopIdAndPaginate($this->shopId, 100);

        if ($brands) {
            return view('frontend.brand.index')->with(array('selectedPage' => $page, 'brands' => $brands));
        }
    }

    public function getItem(Request $request, $slug)
    {
        $page = $request->get('page', 1);
        $brand = $this->brand->selectOneBySlug($this->shopId, $slug);
        $brands = $this->brand->selectAllByShopId($this->shopId);
        if ($brand) {
            $products = $this->product->selectAllByShopIdAndBrandId($this->shopId, $brand->id);
            return view('frontend.brand.item')->with(array('brand' => $brand, 'brands' => $brands, 'products' => $products));
        }

        abort(404);
    }
}
