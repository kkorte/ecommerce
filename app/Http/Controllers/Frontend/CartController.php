<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BrowserDetect;
use Hideyo\Repositories\SendingMethodRepositoryInterface;
use Hideyo\Repositories\PaymentMethodRepositoryInterface;
use Hideyo\Repositories\ShopRepositoryInterface;


class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        SendingMethodRepositoryInterface $sendingMethod,
        PaymentMethodRepositoryInterface $paymentMethod,        
        ShopRepositoryInterface $shop)
    {
        $this->request = $request;
        $this->shop = $shop;
        $this->sendingMethod = $sendingMethod;        
        $this->paymentMethod = $paymentMethod;
        $this->shopId = config()->get('app.shop_id');
    }

    public function getIndex()
    {
        $sendingMethodsList = $this->sendingMethod->selectAllActiveByShopId(config()->get('app.shop_id'));
        $paymentMethodsList = $this->getPaymentMethodsList($sendingMethodsList);

        if (app('cart')->getContent()->count()) {
            
            if(!app('cart')->getConditionsByType('sending_method')->count()) {
                self::updateSendingMethod($sendingMethodsList->first()->id);
            }      

            if (!app('cart')->getConditionsByType('payment_method')->count()) {
                $this->cart->updatePaymentMethod($paymentMethodsList->first()->id);
            }

        } else {
            app('cart')->clear();
            app('cart')->clearCartConditions();           
        }  

        $shop = $this->shop->find(config()->get('app.shop_id'));
        $template = "frontend.cart.index";

        if (BrowserDetect::isMobile()) {
            $template = "frontend.cart.index-mobile";
        }

        return view($template)->with(array( 
            'user' => auth('web')->user(), 
            'sendingMethodsList' => $sendingMethodsList
        ));

    }

    public function getPaymentMethodsList($sendingMethodsList) 
    {
        if ($sendingMethodsList->first()) {
            return $paymentMethodsList = $sendingMethodsList->first()->relatedPaymentMethodsActive;
        }
        
        return $paymentMethodsList = $this->paymentMethod->selectAllActiveByShopId(config()->get('app.shop_id'));       
    }

}