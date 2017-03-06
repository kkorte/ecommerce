<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Auth;
use Validator;
use Mail;
use Notification;
use Illuminate\Http\Request;
use Dutchbridge\Services\Cart;
use Dutchbridge\Repositories\ClientRepositoryInterface;
use Dutchbridge\Repositories\ClientAddressRepositoryInterface;
use Dutchbridge\Repositories\ShopRepositoryInterface;
use Dutchbridge\Repositories\OrderRepositoryInterface;
use Dutchbridge\Repositories\ProductRepositoryInterface;
use Dutchbridge\Repositories\SendingPaymentMethodRelatedRepositoryInterface;
use Beautymail;
use App\ProductAttribute;
use GoogleTagManager;

class AccountController extends Controller
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     */
    public function __construct(Request $request, Cart $cart, ProductRepositoryInterface $product, SendingPaymentMethodRelatedRepositoryInterface $sendingPaymentMethodRelated, OrderRepositoryInterface $order, ClientRepositoryInterface $client, ClientAddressRepositoryInterface $clientAddress, ShopRepositoryInterface $shop)
    {
        $this->auth = Auth::guard('web');

        $this->cart = $cart->getInstance();

        $this->client = $client;
        $this->clientAddress = $clientAddress;
        $this->shop = $shop;
        $this->order = $order;
        $this->product = $product;
        $this->sendingPaymentMethodRelated = $sendingPaymentMethodRelated;
        $this->shopId = config()->get('app.shop_id');
        $request->session()->forget('category_id');
    }

    public function getIndex()
    {
        if (!$this->auth->user()->clientDeliveryAddress()->count()) {
            $this->client->setBillOrDeliveryAddress($this->shopId, $this->auth->user()->id, $this->auth->user()->clientBillAddress->id, 'delivery');
            return redirect()->to('account');
        }

        $user = $this->auth->user();
        $orderProducts = false;
        if ($user->orders->count()) {
            $orderProducts = $this->order->orderProductsByClientId($user->id, $this->shopId)->limit(10)->get();
        }

        return view('frontend.account.index')->with(array('user' => $user, 'orderProducts' => $orderProducts));
    }

    public function getReOrderAll()
    {
        $user = $this->auth->user();
        $orderProducts = false;
        if ($user->orders->count()) {
            $orderProducts = $this->order->orderProductsByClientId($user->id, $this->shopId)->orderBy('title')->get();
        }


        if ($orderProducts) {
            return view('frontend.account.re-order-all')->with(array('orderProducts' => $orderProducts, 'user' => $this->auth->user()));
        }
    }

    public function getReOrder($orderId)
    {
        $order = $this->order->find($orderId);

        if ($order) {
            return view('frontend.account.re-order')->with(array('order' => $order, 'user' => $this->auth->user()));
        }
    }

    public function postReOrderAll(Request $request)
    {
        $input = $request->all();

        if ($input['products']) {
            foreach ($input['products'] as $key => $productInput) {
                $product = $this->product->selectOneByShopIdAndId($this->shopId, $key, false);



                if ($product) {
                    $productCombination = false;
                    if ($productInput['product_attribute_id']) {
                        $productCombination = ProductAttribute::where('id', '=', $productInput['product_attribute_id'])->first();
                    }

                    if ($product->id) {
                        $productArray = $product->toArray();
                        $productArray['product_amount_series'] = false;
                        $productArray['product_category_slug'] = $product->productCategory->slug;
                        $productArray['price_details'] = $product->getPriceDetails();
                        if (isset($productInput['product_amount_series']) and $productInput['product_amount_series']) {
                            $productArray['product_amount_series'] = true;
                            $productArray['product_amount_series_range'] = $product->amountSeries()->where('active', '=', '1')->first()->range();
                        }
                        if ($productCombination) {
                            $productArray['product_combination_title'] = array();
                            foreach ($productCombination->combinations as $combination) {
                                $productArray['product_combination_title'][$combination->attribute->attributeGroup->title] = $combination->attribute->value;
                            }

                            $productArray['product_combination_id'] = $productCombination->id;
                            if ($productCombination->price) {
                                $productArray['price_details'] = $productCombination->getPriceDetails();
                            }

                            if ($productCombination->reference_code) {
                                $productArray['reference_code'] = $productCombination->reference_code;
                            }
                        }

                        if (isset($productInput['checked'])) {
                            $result = $this->cart->add($productArray, $productInput['amount']);
                        }
                    }
                }
            }

            return redirect()->to('winkelwagen');
        }
    }


    public function postReOrder(Request $request, $orderId)
    {
        $order = $this->order->find($orderId);

        if ($order) {
            $input = $request->all();

            if ($input['products']) {
                foreach ($input['products'] as $key => $productInput) {
                    $product = $this->product->selectOneByShopIdAndId($this->shopId, $key, false);

                    $productCombination = false;

                    if (isset($productInput['product_attribute_id'])) {
                        $productCombination = ProductAttribute::where('id', '=', $productInput['product_attribute_id'])->first();
                    }

                    if ($product) {
                        $productArray = $product->toArray();
                        $productArray['product_amount_series'] = false;
                        $productArray['product_category_slug'] = $product->productCategory->slug;
                        $productArray['price_details'] = $product->getPriceDetails();
                        if (isset($productInput['product_amount_series']) and $productInput['product_amount_series']) {
                            $productArray['product_amount_series'] = true;
                            $productArray['product_amount_series_range'] = $product->amountSeries()->where('active', '=', '1')->first()->range();
                        }
                        if ($productCombination) {
                            $productArray['product_combination_title'] = array();
                            foreach ($productCombination->combinations as $combination) {
                                $productArray['product_combination_title'][$combination->attribute->attributeGroup->title] = $combination->attribute->value;
                            }

                            $productArray['product_combination_id'] = $productCombination->id;
                            if ($productCombination->price) {
                                $productArray['price_details'] = $productCombination->getPriceDetails();
                            }

                            if ($productCombination->reference_code) {
                                $productArray['reference_code'] = $productCombination->reference_code;
                            }
                        }

                        if (isset($productInput['checked'])) {
                            $result = $this->cart->add($productArray, $productInput['amount']);
                        }
                    }
                }

                return redirect()->to('winkelwagen');
            }
        }
    }



    public function getDownloadOrder($orderId)
    {
        $order = $this->order->find($orderId);
        
        $pdfText = false;
        if ($order->orderSendingMethod and $order->orderPaymentMethod) {
            $text = $this->sendingPaymentMethodRelated->selectOneByShopIdAndPaymentMethodIdAndSendingMethodId($order->shop->id, $order->orderSendingMethod->sending_method_id, $order->orderPaymentMethod->payment_method_id);

            if ($text) {
                $pdfText = $this->replaceTags($text->pdf_text, $order);
            }
        }

        if ($order) {
            $pdf = \PDF::loadView('admin.order.pdf', array('order' => $order, 'pdfText' => $pdfText));
            return $pdf->download('order-'.$order->generated_custom_order_id.'.pdf');
        } else {
            return redirect()->to('account');
        }
    }

    public function replaceTags($content, $order)
    {

        $replace = array(
            'orderId' => $order->generated_custom_order_id,
            'orderCreated' => $order->created_at,
            'orderTotalPriceWithTax' => $order->getPriceWithTaxNumberFormat(),
            'orderTotalPriceWithoutTax' => $order->getPriceWithoutTaxNumberFormat(),
            'clientEmail' => $order->client->email,
            'clientFirstname' => $order->orderBillAddress->firstname,
            'clientLastname' => $order->orderBillAddress->lastname,
            'clientCompany' => $order->orderBillAddress->company,
            'clientDeliveryFirstname' => $order->orderDeliveryAddress->firstname,
            'clientDeliveryLastname' => $order->orderDeliveryAddress->lastname,
            'clientDeliveryStreet' => $order->orderDeliveryAddress->street,
            'clientDeliveryHousenumber' => $order->orderDeliveryAddress->housenumber,
            'clientDeliveryHousenumberSuffix' => $order->orderDeliveryAddress->housenumber_suffix,
            'clientDeliveryZipcode' => $order->orderDeliveryAddress->zipcode,
            'clientDeliveryCity' => $order->orderDeliveryAddress->city,
            'clientDeliveryCountry' => $order->orderDeliveryAddress->country,
            'clientDeliveryCompany' => $order->orderDeliveryAddress->company,


        );

        foreach ($replace as $key => $val) {
            $content = str_replace("[" . $key . "]", $val, $content);
        }

        return $content;
    }


    public function getEditAccount()
    {

        $user = $this->auth->user();
        $orderProducts = false;
        if ($user->orders->count()) {
            $orderProducts = $this->order->orderProductsByClientId($user->id, $this->shopId)->limit(10)->get();
        }

        return view('frontend.account.edit-account')->with(array('orderProducts' => $orderProducts, 'user' => $this->auth->user()));
    }


    public function getResetAccount($code, $email)
    {

        $result = $this->client->resetAccount($code, $email, $this->shopId);

        if ($result) {
            Notification::container('foundation')->success('Je account gegevens zijn gewijzigd en je dient opnieuw in te loggen met de nieuwe gegevens.');
        } else {
            Notification::container('foundation')->error('Wijziging is niet mogelijk.');
        }

        $this->auth->logout();
        return redirect()->to('account/login');
    }

    public function getEditAddress($type)
    {

        $user = $this->auth->user();
        $orderProducts = false;
        if ($user->orders->count()) {
            $orderProducts = $this->order->orderProductsByClientId($user->id, $this->shopId)->limit(10)->get();
        }

        return view('frontend.account.edit-account-address-'.$type)->with(array('orderProducts' => $orderProducts, 'user' => $this->auth->user()));
    }


    public function postEditAddress(Request $request, $type)
    {

        $userdata = $request->all();

        // create the validation rules ------------------------
        $rules = array(
            'firstname'     => 'required',
            'lastname'      => 'required',
            'zipcode'       => 'required|max:8',
            'housenumber'   => 'required',
            'housenumber_suffix'   => 'max:4',
            'street'        => 'required',
            'city'          => 'required',
            'country'       => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // get the error messages from the validator
            foreach ($validator->errors()->all() as $error) {
                \Notification::container('foundation')->error($error);
            }

            // redirect our user back to the form with the errors from the validator
            return redirect()->to('account/edit-address/'.$type)
                ->with(array('type' => $type))->withInput();
        } else {
                $user = Auth::guard('web')->user();

            if ($type == 'bill') {
                $id = $user->clientBillAddress->id;

                if ($user->clientDeliveryAddress->id == $user->clientBillAddress->id) {
                    $clientAddress = $this->clientAddress->createByClient($userdata, $user->id);
                    $this->client->setBillOrDeliveryAddress($this->shopId, $user->id, $clientAddress->id, $type);
                } else {
                    $clientAddress = $this->client->editAddress($this->shopId, $user->id, $id, $userdata);
                }
            } elseif ($type == 'delivery') {
                $id = $user->clientDeliveryAddress->id;

                if ($user->clientDeliveryAddress->id == $user->clientBillAddress->id) {
                    $clientAddress = $this->clientAddress->createByClient($userdata, $user->id);
                    $this->client->setBillOrDeliveryAddress($this->shopId, $user->id, $clientAddress->id, $type);
                } else {
                    $clientAddress = $this->client->editAddress($this->shopId, $user->id, $id, $userdata);
                }
            }

            return redirect()->to('account');
        }
    }


    public function postEditAccount(Request $request)
    {

        if ($this->auth->check()) {
            $result = $this->client->setAccountChange($this->auth->user(), $request->all(), $this->shopId);

            if ($result) {
                $firstname = false;

                if ($result->clientBillAddress->count()) {
                    $firstname = $result->clientBillAddress->firstname;
                }

                $data = array(
                    'email' => $result->new_email,
                    'firstname' => $firstname,
                    'confirmation_code' => $result->confirmation_code
                );

                Mail::send('frontend.email.reset-account-settings-mail', $data, function ($message) use ($data) {
                    $message->to($data['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Bevestig het wijzigen van jouw accountgegevens');
                });

                Notification::container('foundation')->success('Er is een e-mail gestuurd. Deze dient goedgekeurd te worden voor de wijzigingen.');
            } else {
                Notification::container('foundation')->error('Wij kunnen het niet veranderen. Een ander account maakt er gebruik van.');
            }
        }

        return redirect()->to('account');
    }


    public function getLogin(Request $request)
    {
        if(!$request->session()->get('login_referer')) {
            $request->session()->put('login_referer', $request->server('HTTP_REFERER'));
        }

        if ($this->auth->check()) {
            if($request->session()->get('login_referer')) {
                return redirect()->to($request->session()->get('login_referer'));
            } else {
                return redirect()->to('account');
            }
            
        } else {
            $shop = $this->shop->find($this->shopId);

            if ($shop->wholesale) {
                return view('frontend.account.login-wholesale')->with(array());
            } else {
                return view('frontend.account.login')->with(array());
            }
        }
    }

    public function getRegister()
    {
        $shop = $this->shop->find($this->shopId);
        if ($shop->wholesale) {
            GoogleTagManager::set(array('event' => 'register', 'clientType' => 'wholesale'));
            return view('frontend.account.register-wholesale')->with(array());
        } else {
            GoogleTagManager::set(array('event' => 'register', 'clientType' => 'consumer'));

            return view('frontend.account.register')->with(array());
        }
    }

    public function getForgotPassword()
    {
        return view('frontend.account.forgot-password');
    }

    public function getResetPassword($confirmationCode, $email)
    {
        $result = $this->client->validateConfirmationCodeByConfirmationCodeAndEmail($confirmationCode, $email, $this->shopId);

        if ($result) {
            return view('frontend.account.reset-password')->with(array('confirmationCode' => $confirmationCode, 'email' => $email));
        } else {
            Notification::container('foundation')->error('wachtwoord vergeten is mislukt');
            return redirect()->to('account/forgot-password')
                ->withErrors(true, 'forgot')->withInput();
        }
    }

    public function postResetPassword(Request $request, $confirmationCode, $email)
    {
        // create the validation rules ------------------------
        $rules = array(
            'password'            => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return redirect()->to('account/reset-password/'.$confirmationCode.'/'.$email)
                ->withErrors($validator, 'reset')->withInput();
        } else {
            $result = $this->client->validateConfirmationCodeByConfirmationCodeAndEmail($confirmationCode, $email, $this->shopId);

            if ($result) {
                $result = $this->client->resetPasswordByConfirmationCodeAndEmail(array('confirmation_code' => $confirmationCode, 'email' => $email, 'password' => $request->get('password')), $this->shopId);
                Notification::container('foundation')->success('Je wachtwoord is veranderd en je kan nu inloggen.');
                return redirect()->to('account/login');
            }
        }
    }

    public function postForgotPassword(Request $request)
    {
        // create the validation rules ------------------------
        $rules = array(
            'email'            => 'required|email'
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return redirect()->to('account/forgot-password')
                ->withErrors($validator, 'forgot')->withInput();
        } else {
            $userdata = $request->all();

            $forgotPassword = $this->client->getConfirmationCodeByEmail($userdata['email'], $this->shopId);

            if ($forgotPassword) {
                $firstname = false;

                if ($forgotPassword->clientBillAddress->count()) {
                    $firstname = $forgotPassword->clientBillAddress->firstname;
                }

                $data = array(
                    'email' => $userdata['email'],
                    'firstname' => $firstname,
                    'code' => $forgotPassword->confirmation_code
                );

                Mail::send('frontend.email.reset-password-mail', $data, function ($message) use ($data) {
                    $message->to($data['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Wachtwoord vergeten');
                });

                Notification::container('foundation')->success('Er is een e-mail gestuurd. Hiermee kan je je wachtwoord resetten.');

                return redirect()->to('account/forgot-password');
            } else {
                Notification::container('foundation')->error('Account komt niet bij ons voor.');
                return redirect()->to('account/forgot-password')
                ->withErrors($forgotPassword['errors'], 'forgot')->withInput();
            }

            return redirect()->to('account/forgot-password');
        }
    }

    public function getConfirm($code, $email)
    {
        $result = $this->client->validateConfirmationCodeByConfirmationCodeAndEmail($code, $email, $this->shopId);

        if ($result->count()) {
            $this->client->confirm($code, $email, $this->shopId);
            Notification::container('foundation')->success('Uw account is geactiveerd.');

            return redirect()->to('account/login');
        }

        Notification::container('foundation')->error('Wij kunnen dit niet verwerken.');

        return redirect()->to('account/login');
    }

    public function getLogout(Request $request)
    {
        $this->auth->logout();
        $referrer = $request->headers->get('referer');
        if ($referrer) {
            if (strpos($referrer, 'checkout') !== false) {
                return redirect()->to('cart/checkout');
            }
        }

         return redirect()->to('account/login');
    }

    public function postLogin(Request $request)
    {
        // create the validation rules ------------------------
        $rules = array(
            'email'            => 'required|email',     // required and must be unique in the ducks table
            'password'         => 'required'
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            Notification::error(implode('<br/>', $validator->errors()->all()));
            return redirect()->to('account/login')->withInput();
        } else {
            $userdata = array(
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'confirmed' => 1,
                'active' => 1,
                'shop_id' => $this->shopId
            );

            /* Try to authenticate the credentials */
            if ($this->auth->attempt($userdata)) {
                $this->client->updateLastlogin($this->auth->user()->id);
                // we are now logged in
                
                if($request->session()->get('login_referer')) {
                    return redirect()->to($request->session()->get('login_referer'));
                } else {
                    return redirect()->to('/');
                }

                
            } else {
                if ($this->client->oldPasswordCheck($userdata)) {
                    if ($this->auth->attempt($userdata)) {
                        $this->client->updateLastlogin($this->auth->user()->id);
                        return redirect()->to('account');
                    } else {
                        Notification::container('foundation')->error('De gegevens kloppen niet. ');
                        return redirect()->to('account/login')->withInput();
                    }
                }
                Notification::container('foundation')->error('De gegevens kloppen niet. ');
                return redirect()->to('account/login')->withInput();
            }
        }
    }

    public function postRegister(Request $request)
    {
        $userdata = $request->all();
        $shop = $this->shop->find($this->shopId);

        // create the validation rules ------------------------
        $rules = array(
            'email'         => 'required|email',     // required and must be unique in the ducks table
            'password'      => 'required',
            'firstname'     => 'required',
            'lastname'      => 'required',
            'zipcode'       => 'required',
            'housenumber'   => 'required|numeric',
            'houseletter'   => 'alpha',
            'street'        => 'required',
            'city'          => 'required',
            'country'       => 'required'
        );

        if ($shop->wholesale) {
            // create the validation rules ------------------------
            $rules['company'] = 'required';
            $rules['vat_number'] = 'required';
            $rules['chamber_of_commerce_number'] = 'required';
            GoogleTagManager::flash(array('event' => 'register', 'clientType' => 'wholesale'));
        } else {
            GoogleTagManager::flash(array('event' => 'register', 'clientType' => 'consumer'));
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                \Notification::container('foundation')->error($error);
            }

            // redirect our user back to the form with the errors from the validator
            return \redirect()->back()->withInput();
        } else {
            $registerAttempt = $this->client->validateRegister($userdata, $this->shopId);

            if ($registerAttempt) {
                $register = $this->client->register($userdata, $this->shopId);
            } else {
                 $client = $this->client->findByEmail($userdata['email'], $this->shopId);
                
                if ($client->account_created) {
                    GoogleTagManager::flash('formResponse', 'failed');
                    \Notification::container('foundation')->error('Er is al een account op dit email-adres.');
                    return redirect()->to('account/register')->withInput()->withErrors('Dit emailadres is al in gebruik. Je kan links inloggen.', 'register');
                } else {
                    $register = $this->client->createAccount($userdata, $this->shopId);
                }
            }

            if ($register) {
                GoogleTagManager::flash('formResponse', 'success');
                $data = $register;

                if ($shop->wholesale) {
                    Mail::send('frontend.email.register-mail-wholesale', array('user' => $data->toArray(), 'password' => $request->get('password'), 'billAddress' => $data->clientBillAddress->toArray()), function ($message) use ($data) {
                        $message->to($data['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('je hebt een inlogcode aangevraagd.');
                        $message->bcc("verkoop@foodelicious.nl");
                    });

                    Notification::container('foundation')->success('U heeft zich geregistreerd voor de groothandels bestel website van Foodelicious. U aanvraag zal zo snel mogelijk bekeken worden en na goedkeuring ontvangt u daarover een email.');
                } else {
                    Mail::send('frontend.email.register-mail', array('user' => $data->toArray(), 'password' => $request->get('password'), 'billAddress' => $data->clientBillAddress->toArray()), function ($message) use ($data) {
                        $message->to($data['email'])->from('info@foodelicious.nl', 'Foodelicious')->subject('Je bent geregistreerd.');
                    });
                    Notification::container('foundation')->success('Je bent geregistreerd en kunt nu inloggen. Ter bevestiging hebben wij een e-mail gestuurd.');
                }
               
                return redirect()->to('account/login');
            } else {
                GoogleTagManager::flash('formResponse', 'failed');
                return redirect()->to('account/register')->withErrors($register['errors'], 'register')->withInput();
            }
        }
    }

    public function getZipcode($zipcode = false, $housenumber = false)
    {
        if ($zipcode and $housenumber) {
            $apiKey = '8XJBF85Moj6ST0Xj7V5y19kZ9DQY6HLp88gGnt24';
            $client = new \FH\PostcodeAPI\Client(new \GuzzleHttp\Client(), $apiKey);
            try {
                $response = $client->getAddresses($zipcode, $housenumber);
            } catch (RequestException $e) {
                exit;
            }

            if (!empty($response->_embedded->addresses)) {
                return response()->json(array('address' => $response->_embedded->addresses[0]));
            } else {
                return response()->json(false);
            }
        }
    }
}
