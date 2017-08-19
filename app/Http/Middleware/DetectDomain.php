<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;

use Hideyo\Repositories\ShopRepositoryInterface;
use Hideyo\Repositories\DiscountRepositoryInterface;


use Config;
use \Apiclient;
use \ShopFrontend;
use \View;

class DetectDomain
{


    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(
        ShopRepositoryInterface $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Config::get('app.url') != $request->root()) {
            $root = $request->root();
            Config::set('app.url', $root);
        }

        $shopId = $this->shop->checkByUrl(Config::get('app.url'));

        Config::set('app.shop_id', $shopId);
        
        if (!$shopId) {
            print_r('shop kapot');
            exit;
        }


        return $next($request);
    }
}
