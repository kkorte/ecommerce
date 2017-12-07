<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Http\Request;
use BrowserDetect;
use Hideyo\Repositories\ContentRepositoryInterface;
use Hideyo\Repositories\ProductTagGroupRepositoryInterface;
use Hideyo\Repositories\ShopRepositoryInterface;


class BasicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        ProductTagGroupRepositoryInterface $productTagGroup, 
        ShopRepositoryInterface $shop, 
        ContentRepositoryInterface $content)
    {
        $this->request = $request;
        $this->content = $content;
        $this->shop = $shop;
        $this->productTagGroup = $productTagGroup;

    }

    public function index()
    {        
        $populairProducts = $this->productTagGroup->selectAllByTagAndShopId(config()->get('app.shop_id'), 'home-populair');
        return view('frontend.basic.index')->with(array('populairProducts' => $populairProducts));
    }
}