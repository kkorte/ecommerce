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
        $this->shopId = config()->get('app.shop_id');
    }

    public function index()
    {
        if (BrowserDetect::isMobile() OR BrowserDetect::deviceModel() == 'iPhone') {
            return view('frontend.basic.index-mobile')->with(array());
        }
        
        $populairProducts = $this->productTagGroup->selectAllByTagAndShopId($this->shopId, 'home-populair');
        return view('frontend.basic.index')->with(array('populairProducts' => $populairProducts));
    }
}