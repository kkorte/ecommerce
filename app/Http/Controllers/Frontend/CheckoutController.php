<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BrowserDetect;
use Hideyo\Repositories\ShopRepositoryInterface;
use Hideyo\Repositories\SendingMethodRepositoryInterface;
use Hideyo\Repositories\PaymentMethodRepositoryInterface;
use Cart;
use Validator;
use Notification;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        Request $request,
        ShopRepositoryInterface $shop,
        SendingMethodRepositoryInterface $sendingMethod,
        PaymentMethodRepositoryInterface $paymentMethod)
    {
        $this->request = $request;
        $this->shop = $shop;
        $this->sendingMethod = $sendingMethod;
        $this->paymentMethod = $paymentMethod;
        $this->shopId = config()->get('app.shop_id');
    }

    public function checkout()
    {
        $sendingMethodsList = $this->sendingMethod->selectAllActiveByShopId(config()->get('app.shop_id'));

        if (Cart::getContent()->count()) {

            $paymentMethodsList = Cart::getConditionsByType('sending_method')->first()->getAttributes()['data']['related_payment_methods'];
         
            if(!Cart::getConditionsByType('sending_method')->count()) {
                Notification::error('Selecteer een verzendwijze');
                return redirect()->to('cart');
            }

            if(!Cart::getConditionsByType('payment_method')->count()) {

                Notification::error('Selecteer een betaalwijze');
                return redirect()->to('cart');
            }

        } else {
            return redirect()->to('cart');
        }

        if (auth('web')->guest()) {
            $noAccountUser = session()->get('noAccountUser');
            if ($noAccountUser) {
                if (!isset($noAccountUser['delivery'])) {
                    $noAccountUser['delivery'] = $noAccountUser;
                    session()->put('noAccountUser', $noAccountUser);
                }

                self::checkCountryPrice($noAccountUser['delivery']['country']);

                return view('frontend.checkout.checkout-no-account')->with(array( 
                    'noAccountUser' =>  $noAccountUser, 
                    'sendingMethodsList' => $sendingMethodsList, 
                    'paymentMethodsList' => $paymentMethodsList));
            }
              
             return view('frontend.checkout.login')->with(array(  'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList));
        }

        $user = auth('web')->user();
        self::checkCountryPrice($user->clientDeliveryAddress->country);

        if (!$user->clientDeliveryAddress()->count()) {
            $this->client->setBillOrDeliveryAddress(config()->get('app.shop_id'), $user->id, $user->clientBillAddress->id, 'delivery');
            return redirect()->to(LaravelLocalization::getLocalizedURL(null, 'cart/checkout'));
        }

        return view('frontend.checkout.checkout')->with(array(
            'user' =>  $user, 
            'sendingMethodsList' => $sendingMethodsList, 
            'paymentMethodsList' => $paymentMethodsList));
    }


    public function postCheckoutLogin(Request $request)
    {
        // create the validation rules ------------------------
        $rules = array(
            'email'         => 'required|email',     // required and must be unique in the ducks table
            'password'      => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            foreach ($validator->errors()->all() as $error) {
                Notification::error($error);
            }

            return redirect()->to('cart/checkout')
            ->withErrors(true, 'login')->withInput();
        }

        $userdata = array(
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'confirmed' => 1,
            'active' => 1,
            'shop_id' => config()->get('app.shop_id')
        );

        /* Try to authenticate the credentials */
        if (auth('web')->attempt($userdata)) {
            // we are now logged in, go to admin
            return redirect()->to('cart/checkout');
        }

        Notification::error(trans('message.error.data-is-incorrect'));
        return redirect()->to('cart/checkout')->withErrors(true, 'login')->withInput(); 
    }


}