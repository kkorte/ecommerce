<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hideyo\Repositories\ShopRepositoryInterface;
use Hideyo\Repositories\SendingMethodRepositoryInterface;
use Hideyo\Repositories\PaymentMethodRepositoryInterface;
use Hideyo\Repositories\ClientRepositoryInterface;
use Cart;
use Validator;
use Notification;
use BrowserDetect;

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
        ClientRepositoryInterface $client,
        SendingMethodRepositoryInterface $sendingMethod,
        PaymentMethodRepositoryInterface $paymentMethod)
    {
        $this->request = $request;
        $this->shop = $shop;
        $this->client = $client;
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

  
                return view('frontend.checkout.no-account')->with(array( 
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

        return view('frontend.checkout.index')->with(array(
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

    //to-do: transfer logic to repo
    public function postCheckoutRegister(Request $request)
    {
        if (!Cart::getContent()->count()) {  
            return redirect()->to('cart/checkout');
        }

        $userdata = $request->all();

        $rules = array(
            'email'         => 'required|email',     // required and must be unique in the ducks table
            'password'      => 'required',
            'firstname'     => 'required',
            'lastname'      => 'required',
            'zipcode'       => 'required',
            'housenumber'   => 'required|numeric',
            'street'        => 'required',
            'city'          => 'required'
            );

        if (!$userdata['password']) {
            unset($rules['email']);
            unset($rules['password']);
        }

 

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // get the error messages from the validator
            foreach ($validator->errors()->all() as $error) {
                Notification::error($error);
            }
            // redirect our user back to the form with the errors from the validator
            return redirect()->to('cart/checkout')
            ->withErrors(true, 'register')->withInput();
        } else {

            if ($userdata['password']) {
                $registerAttempt = $this->client->validateRegister($userdata, config()->get('app.shop_id'));

                if ($registerAttempt) {
                    $register = $this->client->register($userdata, config()->get('app.shop_id'));
                } else {
                    $client = $this->client->findByEmail($userdata['email'], config()->get('app.shop_id'));

                    if ($client->account_created) {
                        Notification::error('Je hebt al een account. Login aan de linkerkant of vraag een nieuw wachtwoord aan.');
                        return redirect()->to('cart/checkout')->withInput()->withErrors('Dit emailadres is al in gebruik. Je kan links inloggen.', 'register');
                    } else {
                        $register = $this->client->createAccount($userdata, config()->get('app.shop_id'));
                    }
                }

                if ($register) {
                    $data = $register;
                    $data['shop'] = $this->shop->find(config()->get('app.shop_id'));
            
                    Mail::send('frontend.email.register-mail', array('password' => $userdata['password'], 'user' => $data->toArray(), 'billAddress' => $data->clientBillAddress->toArray()), function ($message) use ($data) {
                
                        $message->to($data['email'])->from($data['shop']->email, $data['shop']->title)->subject('Je bent geregistreerd.');
                    });

                    $userdata = array(
                        'email' => $request->get('email'),
                        'password' => $request->get('password'),
                        'confirmed' => 1,
                        'active' => 1
                    );

                    auth('web')->attempt($userdata);

                    return redirect()->to('cart/checkout')->withErrors('Je bent geregistreerd. Er is een bevestigingsmail gestuurd.', 'login');
                } else {
                    Notification::error('Je hebt al een account');
                    return redirect()->to('cart/checkout')->withErrors(true, 'register')->withInput();
                }
            } else {
                unset($userdata['password']);
                $registerAttempt = $this->client->validateRegisterNoAccount($userdata, config()->get('app.shop_id'));

                if ($registerAttempt) {
                    $register = $this->client->register($userdata, config()->get('app.shop_id'));   
                    $userdata['client_id'] = $register->id;
                } else {
                    $client = $this->client->findByEmail($userdata['email'], config()->get('app.shop_id'));
                    if ($client) {
                        $userdata['client_id'] = $client->id;
                    }
                }

                session()->put('noAccountUser', $userdata);
                return redirect()->to('cart/checkout');
            }
        }
    }

    public function postComplete(Request $request)
    {
        $noAccountUser = session()->get('noAccountUser');
        if (auth('web')->guest() and !$noAccountUser) {
            return view('frontend.checkout.login')->with(array('products' => $products, 'totals' => $totals, 'sendingMethodsList' => $sendingMethodsList, 'paymentMethodsList' => $paymentMethodsList));
        }

        if (!Cart::getContent()->count()) {        
            return redirect()->to('cart/checkout');
        }
    }
}