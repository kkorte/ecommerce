<?php

namespace Hideyo\Shop\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Mail;
use Validator;
use Notification;
use Illuminate\Http\Request;
use hisorange\BrowserDetect\Facade\Parser as BrowserDetect;

use Hideyo\Shop\Repositories\ContentRepositoryInterface;
use Hideyo\Shop\Repositories\ProductTagGroupRepositoryInterface;
use Hideyo\Shop\Repositories\ShopRepositoryInterface;
use GoogleTagManager;

class BasicController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, ProductTagGroupRepositoryInterface $productTagGroup, ShopRepositoryInterface $shop, ContentRepositoryInterface $content)
    {
        $this->request = $request;
        $this->content = $content;
        $this->shop = $shop;
        $this->productTagGroup = $productTagGroup;
        $this->shopId = config()->get('app.shop_id');
    }

    public function index()
    {
        if (BrowserDetect::isMobile()) {
            return view('frontend.basic.index-mobile')->with(array());
        } else {
            $populairProducts = $this->productTagGroup->selectAllByTagAndShopId($this->shopId, 'home-populair');

            return view('frontend.basic.index')->with(array('populairProducts' => $populairProducts));
        }
    }

}
