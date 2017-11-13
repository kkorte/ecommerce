<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BrowserDetect;
use Hideyo\Repositories\ShopRepositoryInterface;


class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        ShopRepositoryInterface $shop)
    {
        $this->request = $request;
        $this->shop = $shop;
        $this->shopId = config()->get('app.shop_id');
    }

    public function index()
    {
    
    }
}